<?php
function autoLoad($file)
{
	switch (basename($file, ".php")) {
		case 'admin': {
			require_once __DIR__ . "/../component/config.php";
				require_once __DIR__ . "/../model/post.php";
			}
			break;
		case 'index': {
				require_once  "controller/getPost.php";
			}
			break;
		case 'getPost': {
				require_once __DIR__ . "/../component/config.php";
				require_once __DIR__ . "/../model/post.php";
			}
			break;
		case 'getUser': {
			require_once __DIR__ . "/../component/config.php";
				require_once __DIR__ . "/../model/user.php";
			}
			break;
		case 'putPost': {
			require_once __DIR__ . "/../component/config.php";
				require_once __DIR__ . "/../model/post.php";
			}
			break;
		default:
			# code...
			break;
	}
}
