<?php

namespace App\Repositories\Backend\Email;

use DB;
use Carbon\Carbon;
use App\Models\Email\Email;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailRepository.
 */
class EmailRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Email::class;

    /**
     * This method is used by Table Controller
     * For getting the table data to show in
     * the grid
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->select([
                config('module.emails.table').'.id',
                config('module.emails.table').'.subject',
                config('module.emails.table').'.body',
                config('module.emails.table').'.sender',
                config('module.emails.table').'.created_at',
                config('module.emails.table').'.updated_at',
            ]);
    }

    /**
     * For Creating the respective model in storage
     *
     * @param array $input
     * @throws GeneralException
     * @return bool
     */
    public function create(array $input)
    {
        if (Email::create($input)) {
            return true;
        }
        throw new GeneralException(trans('exceptions.backend.emails.create_error'));
    }

    /**
     * For updating the respective Model in storage
     *
     * @param Email $email
     * @param  $input
     * @throws GeneralException
     * return bool
     */
    public function update(Email $email, array $input)
    {
    	if ($email->update($input))
            return true;

        throw new GeneralException(trans('exceptions.backend.emails.update_error'));
    }

    /**
     * For deleting the respective model from storage
     *
     * @param Email $email
     * @throws GeneralException
     * @return bool
     */
    public function delete(Email $email)
    {
        if ($email->delete()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.emails.delete_error'));
    }
}
