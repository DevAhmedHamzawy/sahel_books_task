## **Installation Steps**

### 1. Clone the Repository

Clone the project from the repository to your local machine:

```
git clone https://github.com/DevAhmedHamzawy/sahel_books_task.git
cd your-project
2. Install Dependencies
Install the PHP and JavaScript dependencies:



composer install
npm install
3. Set Up the Environment File
Create a .env file by copying the .env.example:



cp .env.example .env
4. Configure the Environment Variables
Update the following variables in the .env file:

Database Configuration:
env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
Application URL:
env

APP_URL=http://localhost
5. Generate Application Key
Run the following command to generate the application encryption key:



php artisan key:generate
6. Migrate the Database
Run the migrations to set up the database tables:



php artisan migrate
7. Seed the Database (Optional)
Seed the database with demo data (if available):



php artisan db:seed
This will create default admin and user accounts (update credentials in the DatabaseSeeder class if needed).

8. Build Frontend Assets
Compile the frontend assets using Vite:



npm run build
9. Run the Application
Start the development server:



php artisan serve
```
