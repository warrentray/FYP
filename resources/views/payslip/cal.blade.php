<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contribution Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            margin-bottom: 10px;
        }

        button {
            padding: 8px 12px;
            font-size: 16px;
            cursor: pointer;
        }

        #result {
            margin-top: 20px;
        }
    </style>
</head>
@include('sweetalert::alert')

<body>
    <h2>Contribution Calculator</h2>

    <label for="age">Age:</label>
    <input type="number" id="age" placeholder="Enter your age">

    <label for="salary">Monthly Salary:</label>
    <input type="number" id="salary" placeholder="Enter your monthly salary">

    <button onclick="calculateContributions()">Calculate Contributions</button>

    <div id="result"></div>
    <p>{{ now()->format('Y-m-d') }} ({{ now()->format('l') }}) </p>

    <script>
        function calculateContributions() {
            var age = document.getElementById('age').value;
            var salary = document.getElementById('salary').value;

            // Validate input
            if (isNaN(age) || isNaN(salary) || age < 0 || salary < 0) {
                alert('Please enter valid values for age and salary.');
                return;
            }

            // Calculate EPF and EIS contributions
            var epfContribution = calculateEPFContributions(age, salary);
            var eisContribution = calculateEISContribution(salary);

            // Display the result
            document.getElementById('result').innerHTML = `
                <h3>Contributions</h3>
                <p>EPF Employee Contribution: ${epfContribution.employee.toFixed(2)}</p>
                <p>EPF Employer Contribution: ${epfContribution.employer.toFixed(2)}</p>
                <p>EIS Contribution: ${eisContribution.toFixed(2)}</p>
                
            `;
        }

        function calculateEPFContributions(age, salary) {
            // Define EPF rates for employees and employers
            var employeeRateBelow60 = 0.11; // 11%
            var employerRateBelow60 = 0.13; // 13%
            
            var employeeRateAbove60 = 0.04; // 4%
            var employerRateAbove60 = 0;    // 0% for employer's share

            // Define EPF contribution limit
            var epfContributionLimit = 5000;

            // Initialize contributions
            var employeeContribution = 0;
            var employerContribution = 0;

            // Determine the EPF contributions based on age and salary
            if (age < 60) {
                employeeContribution = Math.min(salary, epfContributionLimit) * employeeRateBelow60;
                employerContribution = Math.min(salary, epfContributionLimit) * employerRateBelow60;
            } else {
                employeeContribution = Math.min(salary, epfContributionLimit) * employeeRateAbove60;
                employerContribution = Math.min(salary, epfContributionLimit) * employerRateAbove60;
            }

            // Return the contributions as an object
            return {
                employee: employeeContribution,
                employer: employerContribution,
            };
        }

        function calculateEISContribution(salary) {
    var salaryRanges = {
        1000: 2.10,
        1100: 2.30,
        1200: 2.50,
        1300: 2.70,
        1400: 2.90,
        1500: 3.10,
        1600: 3.30,
        1700: 3.50,
        1800: 3.70,
        1900: 3.90,
        2000: 4.10,
        2100: 4.30,
        2200: 4.50,
        2300: 4.70,
        2400: 4.90,
        2500: 5.10,
        2600: 5.30,
        2700: 5.50,
        2800: 5.70,
        2900: 5.90,
        3000: 6.10,
        3100: 6.30,
        3200: 6.50,
        3300: 6.70,
        3400: 6.90,
        3500: 7.10,
        3600: 7.30,
        3700: 7.50,
        3800: 7.70,
        3900: 7.90,
        4000: 7.90,
        [Number.MAX_SAFE_INTEGER]: 7.90, // For salaries above 4000
    };

    var contribution = null;
for (var range in salaryRanges) {
    var lowerBound = parseInt(range);
    var upperBound = lowerBound + 99; // Assuming each range is 100 units

    if (salary >= lowerBound && salary <= upperBound) {
        contribution = salaryRanges[range];
        break;
    }
}

    return contribution;
}
function calculateContribution(monthlyWage) {
            var categories = [
                {'maxWage' , 30, 'employer' , 0.40, 'employee' , 0.10],
        {'maxWage' , 50, 'employer' , 0.70, 'employee' , 0.20},
        {'maxWage' , 70, 'employer' , 1.10, 'employee' , 0.30},
        {'maxWage' , 100, 'employer' , 1.50, 'employee' , 0.40},
        {'maxWage' , 140, 'employer' , 2.10, 'employee' , 0.60},
        {'maxWage' , 200, 'employer' , 2.95, 'employee' , 0.85},
        {'maxWage' , 300, 'employer' , 4.35, 'employee' , 1.25},
        {'maxWage' , 400, 'employer' , 6.15, 'employee' , 1.75},
        {'maxWage' , 500, 'employer' , 7.85, 'employee' , 2.25},
        {'maxWage' , 600, 'employer' , 9.65, 'employee' , 2.75},
        {'maxWage' , 700, 'employer' , 11.35, 'employee' , 3.25},
        {'maxWage' , 800, 'employer' , 13.15, 'employee' , 3.75},
        {'maxWage' , 900, 'employer' , 14.85, 'employee' , 4.25},
        {'maxWage' , 1000, 'employer' , 16.65, 'employee' , 4.75},
        {'maxWage' , 1100, 'employer' , 18.35, 'employee' , 5.25},
        {'maxWage' , 1200, 'employer' , 20.15, 'employee' , 5.75},
        {'maxWage' , 1300, 'employer' , 21.85, 'employee' , 6.25},
        {'maxWage' , 1400, 'employer' , 23.65, 'employee' , 6.75},
        {'maxWage' , 1500, 'employer' , 25.35, 'employee' , 7.25},
        {'maxWage' , 1600, 'employer' , 27.15, 'employee' , 7.75},
        {'maxWage' , 1700, 'employer' , 28.85, 'employee' , 8.25},
        {'maxWage' , 1800, 'employer' , 30.65, 'employee' , 8.75},
        {'maxWage' , 1900, 'employer' , 32.35, 'employee' , 9.25},
        {'maxWage' , 2000, 'employer' , 34.15, 'employee' , 9.75},
        {'maxWage' , 2100, 'employer' , 35.85, 'employee' , 10.25},
        {'maxWage' , 2200, 'employer' , 37.65, 'employee' , 10.75},
        {'maxWage' , 2300, 'employer' , 39.35, 'employee' , 11.25},
        {'maxWage' , 2400, 'employer' , 41.15, 'employee' , 11.75},
        {'maxWage' , 2500, 'employer' , 42.85, 'employee' , 12.25},
        {'maxWage' , 2600, 'employer' , 44.65, 'employee' , 12.75},
        {'maxWage' , 2700, 'employer' , 46.35, 'employee' , 13.25},
        {'maxWage' , 2800, 'employer' , 48.15, 'employee' , 13.75},
        {'maxWage' , 2900, 'employer' , 49.85, 'employee' , 14.25},
        {'maxWage' , 3000, 'employer' , 51.65, 'employee' , 14.75},
        {'maxWage' , 3100, 'employer' , 53.35, 'employee' , 15.25},
        {'maxWage' , 3200, 'employer' , 55.15, 'employee' , 15.75},
        {'maxWage' , 3300, 'employer' , 56.85, 'employee' , 16.25},
        {'maxWage' , 3400, 'employer' , 58.65, 'employee' , 16.75},
        {'maxWage' , 3500, 'employer' , 60.35, 'employee' , 17.25},
        {'maxWage' , 3600, 'employer' , 62.15, 'employee' , 17.75},
        {'maxWage' , 3700, 'employer' , 63.85, 'employee' , 18.25},
        {'maxWage' , 3800, 'employer' , 65.65, 'employee' , 18.75},
        {'maxWage' , 3900, 'employer' , 67.35, 'employee' , 19.25},
        {'maxWage' , 4000, 'employer' , 69.15, 'employee' , 19.75},
        {'maxWage' , 4100, 'employer' , 70.85, 'employee' , 20.25},
        {'maxWage' , 4200, 'employer' , 72.65, 'employee' , 20.75},
        {'maxWage' , 4300, 'employer' , 74.35, 'employee' , 21.25},
        {'maxWage' , 4400, 'employer' , 76.15, 'employee' , 21.75},
        {'maxWage' , 4500, 'employer' , 77.85, 'employee' , 22.25},
        {'maxWage' , 4600, 'employer' , 79.65, 'employee' , 22.75},
        {'maxWage' , 4700, 'employer' , 81.35, 'employee' , 23.25},
        {'maxWage' , 4800, 'employer' , 83.15, 'employee' , 23.75},
        {'maxWage' , 4900, 'employer' , 84.85, 'employee' , 24.25},
        {'maxWage' , 5000, 'employer' , 86.65, 'employee' , 24.75},
                { maxWage: PHP_INT_MAX, employer: 86.65, employee: 24.75 },
            ];

            for (var i = 0; i < categories.length; i++) {
                if (monthlyWage <= categories[i].maxWage) {
                    return {
                        employer: categories[i].employer,
                        employee: categories[i].employee,
                    };
                }
            }

            return {
                employer: 0,
                employee: 0,
            };
        }
    </script>
</body>

</html>