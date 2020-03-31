<?php

namespace App\Http\Responses\Backend\Email;

use Illuminate\Contracts\Support\Responsable;

class EditResponse implements Responsable
{
    /**
     * @var App\Models\Email\Email
     */
    protected $emails;

    /**
     * @param App\Models\Email\Email $emails
     */
    public function __construct($emails)
    {
        $this->emails = $emails;
    }

    /**
     * To Response
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('backend.emails.edit')->with([
            'emails' => $this->emails
        ]);
    }
}