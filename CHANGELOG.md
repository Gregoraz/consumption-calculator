[0.9.0]
- Added check for wrong distance and consuptionPerUnit types

[0.8.0]
- Removed service arguments from services.yaml and services_test.yaml due to auto write option

[0.7.0]
- Created Cars, tests for cars and CarConsumptionCalculator
- Added return type self for abstract car in all setters

[0.5.0]
- Created ConsumptionCalculatorControllerTest
- Added comments to interfaces

[0.4.0]
- Added rate limiter, in case of a paid/limited endpoints
- Implemented Consumption Calculator route
- Restricted calculator visibility, to ContentType application/json with expressions
- Added json_request_bundle to handle json requests easily

[0.3.0]
- Added monolog bridge to symfony project. Logging is supported right now
- Added Calculator Controller

[0.2.0]
- Created Number Validator

[0.1.0]
- Created Consumption Calculator
- Created Consumption Calculator Test
- Created custom exception for negative number
