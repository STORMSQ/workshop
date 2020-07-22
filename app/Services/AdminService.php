<?php
namespace App\Services;
use App\Repositories\AdminRepository;
class AdminService{
    protected $AdminRepository;
    public function __construct(AdminRepository $AdminRepository)
    {
        $this->AdminRepository = $AdminRepository;
    }
    public function action(array $data)
    {
        return $this->AdminRepository->signup_action($data);
        //App::bind(\App\Services\Signup\ActionInterface::class,'\App\Services\Signup\\'.$data['type']);
        //return app(\App\Services\Signup\ActionInterface::class)->do($data);
    }
}