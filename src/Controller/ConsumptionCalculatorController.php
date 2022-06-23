<?php

namespace App\Controller;

use App\Calculator\ConsumptionCalculator\ConsumptionCalculatorInterface;
use App\Calculator\ConsumptionCalculator\ConsumptionCarCalculatorInterface;
use App\Calculator\ConsumptionUnit;
use App\Calculator\DriveType;
use App\Exception\NegativeNumberNotAllowedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\RateLimiter\Exception\RateLimitExceededException;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;

class ConsumptionCalculatorController extends AbstractController
{
    public function __construct(
        protected ConsumptionCalculatorInterface $consumptionCalculator,
        protected ConsumptionCarCalculatorInterface $test
    ){}

    /**
     *
     * {
     *      distance(float) *required
     *      consumptionPerUnit(float) *required
     *      consumptionUnit(enum) [litres_per_hundred_kilometer, miles_per_gallon, kilowatt_hour_per_hundred_kilometer]
     *      driveType(enum) [diesel, petrol, electric]
     * }
     *
     * @param Request $request
     * @param RateLimiterFactory $calculationLimitLimiter
     * @return JsonResponse
     */
    #[Route(
        '/calculator/calculate-consumption/',
        name: 'consumption_calculator',
        methods: 'POST',
        condition: "request.headers.get('Content-Type') === 'application/json'"
    )]
    public function calculate(Request $request, RateLimiterFactory $calculationLimitLimiter): JsonResponse
    {
        //Check for required parameters
        if (!$request->get('distance') || !$request->get('consumptionPerUnit')) {
            return $this->sendExceptionJsonResponse(
                new MissingMandatoryParametersException(
                    'distance and consumptionPerUnit parameters are required',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                ));
        }

        //Check for valid distance
        if(!(float)$request->get('distance')) {
            return new JsonResponse([
                    'success' => false,
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'message' => sprintf('Wrong argument type for "distance". Expected: float, received: %s',
                        gettype($request->get('distance'))
                    )]
            , Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //Check for valid consumptionPerUnit
        if(!(float)$request->get('consumptionPerUnit')) {
            return new JsonResponse([
                    'success' => false,
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'message' => sprintf('Wrong argument type for "consumptionPerUnit". Expected: float, received: %s',
                        gettype($request->get('consumptionPerUnit'))
                    )]
            , Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //Check for valid consumption unit enum value
        if ($request->request->has('consumptionUnit') && !ConsumptionUnit::tryFrom($request->get('consumptionUnit'))) {
            return $this->sendInvalidEnumJsonResponse(
                $request->get('consumptionUnit'),
                'consumptionUnit',
                array_column(ConsumptionUnit::cases(), 'value')
            );
        }

        //Check for valid drive type enum value
        if ($request->request->has('driveType') && !DriveType::tryFrom($request->get('driveType'))) {
            return $this->sendInvalidEnumJsonResponse(
                $request->get('driveType'),
                'driveType',
                array_column(DriveType::cases(), 'value')
            );
        }

        //Rate limiter consumption
        try {
            $calculationLimitLimiter->create($request->getClientIp())->consume(1)->ensureAccepted();
        } catch (RateLimitExceededException $exception) {
            return $this->sendExceptionJsonResponse($exception);
        }

        //Calculation
        try {
            $consumptionCalculation = $this->consumptionCalculator->calculate(
                $request->get('distance'),
                $request->get('consumptionPerUnit'),
                ConsumptionUnit::tryFrom($request->get('consumptionUnit', '')) ?? ConsumptionUnit::LITRES_PER_HUNDRED_KILOMETER,
                DriveType::tryFrom($request->get('driveType', '')) ?? DriveType::PETROL
            );
        } catch (NegativeNumberNotAllowedException|\Exception $exception) {
            return $this->sendExceptionJsonResponse($exception);
        }

        return new JsonResponse($consumptionCalculation);
    }

    private function sendExceptionJsonResponse(\Throwable $throwable): JsonResponse
    {
        //probably giving code and success parameters is not good, because we could identify this with response status code
        return new JsonResponse([
            'success' => false,
            'message' => $throwable->getMessage(),
            'code' => $throwable->getCode(),
        ], $throwable->getCode());
    }

    private function sendInvalidEnumJsonResponse(string $currentValue, string $key, array $enumCases): JsonResponse
    {
        //probably giving code and success parameters is not good, because we could identify this with response status code
        $enumCasesString = implode(', ', $enumCases);
        return new JsonResponse([
            'success' => false,
            'message' => sprintf(
                'Value %s is not valid enum type for %s. Valid values: [%s].',
                $currentValue,
                $key,
                $enumCasesString
            ),
            'code' => Response::HTTP_UNPROCESSABLE_ENTITY
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
