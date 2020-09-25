<?php
namespace KentaroA\PHPCommander;

class ValidatorNotEmptyString extends Validator {
	public function validate($flg, $value): bool {
		if (trim($value) === "") {
			return false;
		} else {
			return true;
		}
	}
}
