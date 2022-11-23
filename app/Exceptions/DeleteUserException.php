<?php

namespace App\Exceptions;

use Exception;

class DeleteUserException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->view('errors.delete-user',
            ["message" => 'Cannot delete the last admin in the system.',
                "status" => 409
            ], 409
        );
    }
}
