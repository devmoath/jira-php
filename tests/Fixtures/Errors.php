<?php

function errorMessage(): array
{
    return [
        'errorMessage' => "Unable to to create request because of theses errors : The field 'customfield_14304' is not valid for this request type 'support'.",
        'i18nErrorMessage' => [
            'i18nKey' => 'sd.request.create.error.failed.msg',
            'parameters' => [
                "The field 'customfield_14304' is not valid for this request type 'support'.",
            ],
        ],
    ];
}

function errorMessages(): array
{
    return [
        'errorMessages' => [
            'Internal server error',
        ],
        'errors' => [],
    ];
}

function errors(): array
{
    return [
        'errorMessages' => [],
        'errors' => [
            'customfield_18208' => "Field 'customfield_18208' cannot be set. It is not on the appropriate screen, or unknown.",
        ],
    ];
}
