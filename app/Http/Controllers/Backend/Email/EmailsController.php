<?php

namespace App\Http\Controllers\Backend\Email;

use App\Models\Email\Email;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Http\Responses\Backend\Email\CreateResponse;
use App\Http\Responses\Backend\Email\EditResponse;
use App\Repositories\Backend\Email\EmailRepository;
use App\Http\Requests\Backend\Email\ManageEmailRequest;
use App\Http\Requests\Backend\Email\CreateEmailRequest;
use App\Http\Requests\Backend\Email\StoreEmailRequest;
use App\Http\Requests\Backend\Email\EditEmailRequest;
use App\Http\Requests\Backend\Email\UpdateEmailRequest;
use App\Http\Requests\Backend\Email\DeleteEmailRequest;

/**
 * EmailsController
 */
class EmailsController extends Controller
{
    /**
     * variable to store the repository object
     * @var EmailRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param EmailRepository $repository;
     */
    public function __construct(EmailRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\Backend\Email\ManageEmailRequest  $request
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageEmailRequest $request)
    {
        return new ViewResponse('backend.emails.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateEmailRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Email\CreateResponse
     */
    public function create(CreateEmailRequest $request)
    {
        return new CreateResponse('backend.emails.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEmailRequestNamespace  $request
     * @return \App\Http\Responses\RedirectResponse
     */
    // public function store(StoreEmailRequest $request)
    // {
    //     //Input received from the request
    //     $input = $request->except(['_token']);
    //     //Create the model using repository create method
    //     $this->repository->create($input);
    //     //return with successfull message
    //     return new RedirectResponse(route('admin.emails.index'), ['flash_success' => trans('alerts.backend.emails.created')]);
    // }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Email\Email  $email
     * @param  EditEmailRequestNamespace  $request
     * @return \App\Http\Responses\Backend\Email\EditResponse
     */
    public function edit(Email $email, EditEmailRequest $request)
    {
        return new EditResponse($email);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEmailRequestNamespace  $request
     * @param  App\Models\Email\Email  $email
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(UpdateEmailRequest $request, Email $email)
    {
        //Input received from the request
        $input = $request->except(['_token']);
        //Update the model using repository update method
        $this->repository->update( $email, $input );
        //return with successfull message
        return new RedirectResponse(route('admin.emails.index'), ['flash_success' => trans('alerts.backend.emails.updated')]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteEmailRequestNamespace  $request
     * @param  App\Models\Email\Email  $email
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Email $email, DeleteEmailRequest $request)
    {
        //Calling the delete method on repository
        $this->repository->delete($email);
        //returning with successfull message
        return new RedirectResponse(route('admin.emails.index'), ['flash_success' => trans('alerts.backend.emails.deleted')]);
    }
    
}
