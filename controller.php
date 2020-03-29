<?php
/*
 * Copyright (c) Codiad & Andr3as, distributed
 * as-is and without warranty under the MIT License.
 * See [root]/license.md for more information. This information must remain intact.
 */

require_once('../../common.php');
checkSession();

$action = Common::data("action");
$path = Common::data("path");
$path = Common::getWorkspacePath($path);
$code = Common::data("code");

if (!$action) {
	Common::sendJSON("error", "Missing Action");
	die;
}

switch ($action) {

	/**
	* Compress a css file.
	*
	* @param {string} path The path of the file to compress
	* @param {string} code Compressed code
	*/
	case 'compressCSS':
		case 'compressJS':
			if ($path && $code) {
				if ($action == "compressCSS") {
					$ext = ".css";
					$print = "CSS";
				} else {
					$ext = ".js";
					$print = "JS";
				}
				$nFile = substr($path, 0, strrpos($path, $ext));
				$nFile = $nFile . ".min".$ext;
				file_put_contents($nFile, $code);
				Common::sendJSON("success", "$print minified.");
			} else {
				if ($path) {
					Common::sendJSON("error", "Missing Code");
				} else {
					Common::sendJSON("error", "Missing Path");

				}
			}
			break;

		/**
		* Get file content
		*
		* @param {string} path The path of the file
		*/
		case 'getContent':
			if ($path) {
				Common::sendJSON("success", file_get_contents($path));
			} else {
				Common::sendJSON("error", "Missing Path");
			}
			break;

		default:
			Common::sendJSON("error", "Invalid Action");
			break;
}
?>