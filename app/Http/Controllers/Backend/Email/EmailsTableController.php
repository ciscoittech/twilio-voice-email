<?php

namespace App\Http\Controllers\Backend\Email;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Backend\Email\EmailRepository;
use App\Http\Requests\Backend\Email\ManageEmailRequest;

/**
 * Class EmailsTableController.
 */
class EmailsTableController extends Controller
{
    /**
     * variable to store the repository object
     * @var EmailRepository
     */
    protected $email;

    /**
     * contructor to initialize repository object
     * @param EmailRepository $email;
     */
    public function __construct(EmailRepository $email)
    {
        $this->email = $email;
    }

    /**
     * This method return the data of the model
     * @param ManageEmailRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageEmailRequest $request)
    {
        return Datatables::of($this->email->getForDataTable())
            ->escapeColumns(['id'])
            ->addColumn('subject', function ($email) {
                return $email->subject;
            })
            ->addColumn('body', function ($email) {
                return $email->body;
            })
            ->addColumn('sender', function ($email) {
                return $email->sender;
            })
            ->addColumn('received_at', function ($email) {
                return Carbon::parse($email->created_at)->toDateString();
            })
            ->addColumn('actions', function ($email) {
                return $email->action_buttons;
            })
            ->make(true);
    }
}
