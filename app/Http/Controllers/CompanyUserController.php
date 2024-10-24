<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyUserController extends Controller
{
    public function index(Company $company)
    {
        $users = $users = $company->users()->where('role_id', Role::COMPANY_OWNER->value)->get();

        return view('companies.users.index', compact('company', 'users'));
    }
}
