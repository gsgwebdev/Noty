<?php

class Form {
  private $fields;
  private $fieldsErr;
  private $validFields;

  /*
   * Set values for the form's fields,
   * for the errors and for the valid values
   */
  public function __construct($fields) {
    foreach ($fields as $field=>$value) {
      $this->fields[$field] = $value;
      $this->fieldsErr[$field] = $value;
      $this->validFields[$field] = $value;
    }
  }

  public function setField($field, $value) {
    $this->fields[$field] = $value;
  }

  /*
   * Get the values as an associative array
   */
  public function getFields() {
    return $this->fields;
  }

  public function getFieldsErr() {
    return $this->fieldsErr;
  }

  public function getValidFields() {
    return $this->validFields;
  }

  /*
   * Validation for string, email, password and numbers
   */
  public function strValidation($minLen, $maxlen, $field) {
    if (empty($this->fields[$field])) {
      $this->fieldsErr[$field] = "Please insert an {$field}.";
    } else if (strlen($this->fields[$field]) < $minLen) {
      $this->fieldsErr[$field] = "The {$field} should be longer than {$minLen} characters.";
    } else if (strlen($this->fields[$field]) > $maxlen) {
      $this->fieldsErr[$field] = "The {$field} should should be shorter than {$maxlen} characters.";
    } else {
      $this->fields[$field] = htmlspecialchars(strip_tags($_POST[$field]));
      $this->validFields[$field] = true;
    }
  }

  /*
   * If the fourth argument is set to true, then we refer to
   * the length of the value(e.g.: length 10 => 1234567892).
   * Otherwise, we refer to a range(e.g.: [min, max])
   */
  public function numValidation($min, $max, $field, $fixedSize) {
    if (empty($this->fields[$field])) {
      $this->fieldsErr[$field] = "Please insert an {$field}.";
    } else if ($fixedSize == true && strlen($this->fields[$field]) != $max) {
      $this->fieldsErr[$field] = "The {$field} should contains {$max} characters.";
    } else if ($fixedSize == false && ($this->fields[$field] < $min || $this->fields[$field] > $max)) {
      $this->fieldsErr[$field] = "The {$field} should be a number between {$min} and {$max}.";
    } else {
      $this->fields[$field] = htmlspecialchars(strip_tags($_POST[$field]));
      $this->validFields[$field] = true;
    }
  }

  public function linkValidation($field) {
    $regex = '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;\':<]|\.\s|$)#i';

    if (empty($this->fields[$field])) {
      $this->fieldsErr[$field] = 'Please insert a link.';
    } else if(preg_match($regex, $this->fields[$field])) {
      $this->fields[$field] = htmlspecialchars(strip_tags($_POST[$field]));
      $this->validFields[$field] = true;
      return $_POST[$field];
    } else {
      $this->fieldsErr[$field] = 'The link has not a valid format.';
    }
  }

  public function emailValidation($field) {
    if (empty($this->fields[$field])) {
      $this->fieldsErr[$field] = 'Please type your email.';
    } else {
      $this->fields[$field] = htmlspecialchars(strip_tags($this->fields[$field]));
      if (!filter_var($this->fields[$field], FILTER_VALIDATE_EMAIL)) {
        $this->fieldsErr[$field] = 'Invalid email format.';
      } else {
        $this->validFields[$field] = true;
      }
    }
  }

  public function passwordVerification($field) {
    if (empty($this->fields[$field])) {
      $this->fieldsErr[$field] = 'Please select a password';
    } else if (strlen($this->fields[$field]) < 6) {
      $this->fieldsErr[$field] = 'The password should be longer than 6 characters.';
    } else {
      $this->fields[$field] = htmlspecialchars(strip_tags($this->fields[$field]));
      $passwordHash = password_hash($this->fields[$field], PASSWORD_DEFAULT);
      $this->validFields[$field] = true;
      return $passwordHash;
    }
  }

  public function passwordConfirmation($field) {
    if (empty($this->fields[$field])) {
      $this->fieldsErr[$field] = 'Please retype your password';
    } else if ($this->fields[$field] != $this->getFields()['password']) {
      $this->fieldsErr[$field] = 'The password does not match.';
    } else {
      $this->validFields[$field] = true;
    }
  }

  /*
   * If all fields have valid values, then return true
   */
  public function allFieldsOK() {
    foreach ($this->validFields as $field) {
      if ($field != 1) {
        return false;
      }
    }
    return true;
  }
}