<?php

class ErrorResponse {
    public $status;
    public $message;
    public $action;
    public $missingFields = [];

    public function __construct($status, $message, $action = null, $missingFields = []) {
        $this->status = $status;
        $this->message = $message;
        $this->action = $action;
        $this->missingFields = $missingFields;
    }

    public function toJson() {
        // Convert the object to an array
        $array = [
            'status' => $this->status,
            'message' => $this->message,
            'action' => $this->action
        ];

        // Include missingFields only if it is not empty
        if (!empty($this->missingFields)) {
            $array['missingFields'] = $this->missingFields;
        }

        return json_encode($array);
    }
}

class Exceptions {
    
    public static function invalidRequestMethod($action = null) {
        return new ErrorResponse("error", "invalid request method", $action);
    }

    public static function notFound($field = null, $action = null) {
        $message = $field === null ? "data not found" : "$field not found";
        return new ErrorResponse("error", $message, $action);
    }

    public static function fieldRequired($action = null, ...$fields) {
        $fieldList = implode(", ", $fields);
        $message = "fields required: ". $fieldList;
        return new ErrorResponse("error", $message, $action, $fields);
    }

    public static function invalidFormat($action = null) {
        return new ErrorResponse("error", "invalid request format", $action);
    }

    public static function tokenRequired($action = null) {
        return new ErrorResponse("error", "token is required", $action);
    }

    public static function customError($message, $action = null) {
        return new ErrorResponse("error", $message, $action);
    }
}
