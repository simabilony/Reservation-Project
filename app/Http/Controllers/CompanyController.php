<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function create()
    {
        return view('companies.create');
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        Company::create($request->validated());

        return to_route('companies.index');
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $company->update($request->validated());

        return to_route('companies.index');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return to_route('companies.index');
    }
}
