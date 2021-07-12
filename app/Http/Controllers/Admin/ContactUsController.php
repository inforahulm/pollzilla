<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ContactUsDataTable;

class ContactUsController extends Controller
{
	public function index(ContactUsDataTable $contactUsDataTable)
	{
		return $contactUsDataTable->render('admin.contactus.index');
	}
}
