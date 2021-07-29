<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PasswordServices;
use App\Services\HomeServices;
use App\Services\CommonServices;
use App\Services\EmployeeServices;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PasswordController extends Controller
{
  /**
   * コンストラクタ作成
   * @param HomeServices
   */
  public function __construct(PasswordServices $passwordService, HomeServices $homeService, EmployeeServices $employeeService, CommonServices $commonService)
  {
    $this->passwordService = $passwordService;
    $this->homeService = $homeService;
    $this->employeeService = $employeeService;
    $this->commonService = $commonService;
  }

  public function changePassword() {
    
    return view('pages.password.change', []);
  }

  public function resetPassword() {

    return view('pages.password.reset', []);
  }


}
