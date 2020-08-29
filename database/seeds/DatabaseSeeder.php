<?php

use App\Company;
use App\CompanyDepartment;
use App\ContactInfo;
use App\Employee;
use App\JobDetail;
use App\Profile;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::managerEmails() as $email) {
            $manager = $this->createUser(['email' => $email]);

            /**
             * @var $company Company
             */
            $company = $manager->company()
                ->create(
                    factory(Company::class)
                        ->make(['no_of_employees' => $no_of_employees = random_int(10, 100)])
                        ->toArray()
                );

            collect(self::departments())->each(function (string $name) use ($company) {
                $company->companyDepartments()->create(
                    factory(CompanyDepartment::class)->make(['name' => $name])->toArray()
                );
            });


            /**
             * Employess needs a user_id, so we will create a user model first.
             */
            $employees = factory(Employee::class, $no_of_employees)->make(['company_id' => $company->id]);

            $employees->each(function (Employee $employee) use ($company, $manager) {
                $contactInfos = factory(ContactInfo::class)->make()->toArray();
                /**
                 * @var $newEmployee Employee
                 */
                $newEmployee = $manager->employees()->create($employee->toArray());
                $newEmployee->contactInfo()->create($contactInfos);
                $newEmployee->jobDetails()->create(factory(JobDetail::class)->make()->toArray());
            });
        }
    }

    protected function createUser(array $data = []): User
    {
        $manager = factory(User::class)->create($data);
        factory(Profile::class)->create(['user_id' => $manager->id]);

        return $manager;
    }

    public static function managerEmails(): array
    {
        return [
            'hr@starthub.com.ng',
        ];
    }

    public static function departments(): array
    {
        return [
            'Cleaning',
            'Engineering',
            'Data Science',
            'Human Resources',
            'User Experience',
            'Automation',
            'Sales'
        ];
    }
}
