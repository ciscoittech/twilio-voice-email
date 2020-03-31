<?php

namespace App\Models\Email\Traits;

/**
 * Class EmailAttribute.
 */
trait EmailAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-email", "admin.emails.edit")}
                {$this->getDeleteButtonAttribute("delete-email", "admin.emails.destroy")}
                </div>';
    }
}
