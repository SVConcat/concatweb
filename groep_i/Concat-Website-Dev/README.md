# Studievereniging Concat Website
This repository contains the source code for the website of the Concat Study Association

## Coding Guidelines
To maintain a clean and consistent codebase, we adhere to the following coding guidelines:

### 1. PHP CodeSniffer
We use [PHP CodeSniffer](https://github.com/PHPCSStandards/PHP_CodeSniffer/) to enforce the [PEAR](https://pear.php.net/manual/en/standards.php) coding standard. Make sure to run PHP CodeSniffer before committing your code to check for any violations.

### 2. Clean Code Principles
In order to keep our code readable, reusable, and refactorable, we follow the clean code principles outlined in [Clean Code PHP](https://github.com/piotrplenik/clean-code-php). While PHP CodeSniffer helps enforce coding standards and detect formatting issues, it does not check for the actual meaning or clarity of elements like variable names or function descriptions. 

</br> **Important:** In cases where there is overlap between the concepts covered by both PHP CodeSniffer and Clean Code PHP, the rules enforced by PHP CodeSniffer take priority.

### 3. Branch Naming Conventions
**Use Separators** <br/>
Always use separators such as hyphens (-) or slashes (/) to improve readability in branch names. Maintain consistency with the chosen separator across all branches.

    Example: optimize-data-analysis or optimize/data/analysis

**Start Name with a Category Word** </br>
Branch names should begin with with a category word, which indicates the type of task that is being solved with that branch.
| Category  | Meaning                                                                    |
| --------- | -------------------------------------------------------------------------- |
| `hotfix`  | for quickly fixing critical issues,  <br>usually with a temporary solution |
| `bugfix`  | for fixing a bug                                                           |
| `feature` | for adding, removing or modifying a feature                                |
| `test`    | for experimenting something which is not an issue                          |
| `wip`     | for a work in progress                                                     |

**Include the Issue ID** </br>
Append the related issue ID to the branch name to make it easier to identity and keep track of its progress.

    Example: wip-451-optimize-data-analysis

## Managing Issues
1. **Search Existing Issues**: Before creating a new issue, search the existing issues to see if a similar issue has already been reported.
2. **Create a New Issue**: If the issue hasn't been reported yet, create a new one with a clear and descriptive title. Then, create a branch specifically for that issue and link the issue to the branch.
3. **Provide Details**: Include as much detail as possible in the issue description, including steps to reproduce the issue, expected behavior, and actual behavior.
4. **Label the Issue**: Apply appropriate labels to the issue to help categorize and prioritize it.

## Development
### 1. Prerequisites
- Laravel Herd 1.16.0 or higher
- Node.js 22.13.0 or higher

### 2. Steps
1. Clone the repository by running:  
   ```sh
   git clone https://github.com/SOPRJ7-I/Concat-Website.git
   ```  
2. Navigate to the application folder using the `cd` command in your terminal.  
3. Install dependencies by running:  
   ```sh
   composer install
   ```  
4. Set up the environment file:  
   - In the project’s root folder, create a `.env` file and copy the contents of `.env.example` into it manually,  
     **OR** run the following command in your terminal:  
     ```sh
     copy .env.example .env
     ```  
5. Configure database credentials:  
   - Open the `.env` file and update the following fields with the correct credentials:  
     ```env
     DB_DATABASE=your_database_name
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```  
6. Run the following commands:  
   ```sh
   php artisan key:generate
   php artisan storage:link
   php artisan migrate
   ```  
   - When prompted, enter `yes`.
   <br>
   
   ```sh
   npm install
   ```  
7. Ensure Laravel Herd has access to the application folder. Within Laravel Herd navigate to **General → Add Path** and add the folder containing the project. Like so:
   ```
   .
   └── Outer folder
       └── Concat-Website
           └── Project files
   ```
9. Access the application by visiting:  
   ```
   http://concat-website.test
   ```
## Testing
### 1. Running browser tests (Laravel Dusk)
1. Run the following command:

   ```sh
   php artisan dusk:install
   ```
2. Before running the Dusk tests, you need to manually start the ChromeDriver executable:
    *   Navigate to the ChromeDriver directory within your project: `vendor/laravel/dusk/bin/`.
    *   Run the executable `chromedriver-win.exe`.

3. Identify the ChromeDriver Port: <br>
    When ChromeDriver starts successfully, it will print an output to your terminal, including the port it is running on. Look for a line similar to this:
    ```
    ChromeDriver was started successfully on port 50976.
    ```
4. Ensure the following variables are correctly set in your `.env` file:
    ```env
    APP_URL=https://concat-website.test/
    DUSK_DRIVER_URL=http://localhost:50976
    ```
    _In this example the port number (e.g. `50976') should be the port that was printed in your terminal when you ran the ChromeDriver executable_
5. Run Dusk Tests: <br>
   Now that ChromeDriver is running and your `.env` file is configured with the correct port, you can execute the Dusk tests from your project's root directory:
    ```sh
    php artisan dusk
    ```
---
_Important Info: You might see a warning like: `Warning: TTY mode is not supported on Windows platform.`, This is normal and can be safely ignored, the tests should still run correctly._

## Comments
TBD
