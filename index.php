<?php
require_once __DIR__ . "/component/autoLoad.php";
autoLoad(__FILE__);
if (!isset($_GET['page']) || !isset($_GET['sort_name']) || !isset($_GET['sort_type'])) header("location: index.php?page=1&sort_name=name&sort_type=asc&admin=0");
$page = (!isset($_GET['page']) || $_GET["page"] < 1) ? 1 : $_GET["page"];
$sortName = !isset($_GET['sort_name']) ? 'name' : $_GET['sort_name'];
$sortType = !isset($_GET['sort_type']) ? '0' : $_GET['sort_type'];
$adminMod = !isset($_GET['admin']) ? '0' : $_GET['admin'];
$dataPost = getInfo((int)$page, $sortName, $sortType);
function getLink($page, $sortName, $sortType, $adminMod)
{
	return '?page=' . $page . '&sort_name=' . $sortName . '&sort_type=' . $sortType . "&admin=" . $adminMod;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/style/style.css">
	<title>DoIt</title>
</head>

<body>
	<header>
		<?php if ($adminMod == 0) { ?>
			<a href="public/login.html" class="authorization">authorization</a>
		<?php } else { ?>
			<h3>Вы Админ</h3>
		<?php } ?>
	</header>
	<main>
		<article class="table-question">
			<div class="table-question__sort">
				Сортировать по:
				<ul class="sort__list">
					<li class="sort__element">
						<a href="<?php echo getLink($page, 'name', $sortType, $adminMod) ?>" class="sort__link">Имя</a>
					</li>
					<li class="sort__element">
						<a href="<?php echo getLink($page, 'email', $sortType, $adminMod) ?>" class="sort__link">Почта</a>
					</li>
					<li class="sort__element">
						<a href="<?php echo getLink($page, 'status', $sortType, $adminMod) ?>" class="sort__link">Статус</a>
					</li>
					<li class="sort__element">
						<a href="<?php echo getLink($page, $sortName, "1", $adminMod) ?>" class="sort__link">Убывание</a>
					</li>
					<li class="sort__element">
						<a href="<?php echo getLink($page, $sortName, "0", $adminMod) ?>" class="sort__link">Возростание</a>
					</li>
				</ul>
			</div>
			<ul class="table-question__list">
				<?php
				for ($i = 0; $i < count($dataPost['post']); $i++) {
					$post = $dataPost['post'][$i];
					$resultText = "";
					if ($adminMod == 1) {
						$resultText .= '<form action="/controller/admin.php" method="POST">';
					}
					$resultText .= '<li class="table-question__question question">
					<div class="question__wrapper">
						<div class="question__head">';
					if ($adminMod == 1) {
						$resultText .= '<input class="question__name" name="name" value="' . $post['name'] . '">
							<div class="question__mail">' . $post['email'] . '</div>
							<div class="question__status">' . (($post['status'] == 0) ? "Не выполнено" : "Выполнено");
					} else {
						$resultText .= '<div class="question__name">' . $post['name'] . '</div>
							<div class="question__mail">' . $post['email'] . '</div>
							<div class="question__status">' . (($post['status'] == 0) ? "Не выполнено" : "Выполнено");
					}
					if ($adminMod == 1) {
						$resultText .= ' |<input type="checkbox" name="st"'. (($post['status'] == 1)? 'checked="1"':"" ).'> </div>
							</div>
							<div class="question__text-box">
								<textarea class="question__text" name="text">' . $post['text'] . '</textarea>
							</div>
						</div>
					</li>';
					} else {
						$resultText .= '</div>
							</div>
							<div class="question__text-box">
								<p class="question__text">' . $post['text'] . '</p>
							</div>
						</div>
					</li>';
					}
					if ($adminMod == 1) {
						$resultText .= '<button class="question__send">Потвердить</button>
						</form>';
					}
					echo $resultText;
				}
				?>
			</ul>
			<div class="table-question__pagination pagination">
				<ul class="pagination__list">
					<li class="pagination__element">
						<!-- <a href="#" class="pagination__link">1</a> -->
						<?php
						for ($i = 0; $i < $dataPost['page']; $i++) {
							echo '<a href="' . getLink($i + 1, $sortName, $sortType, $adminMod) . '" class="pagination__link">' . ($i + 1) . '</a>';
						}

						?>
					</li>
				</ul>
			</div>
			<div class="table-question__add-question add-question">
				<form action="/controller/putPost.php" method="POST" class="add-question__question question">
					<div class="question__wrapper">
						<div class="question__head">
							<input maxlength="30" minlength="3" placeholder="name" name="name" class="question__name">
							<input maxlength="100" minlength="3" type="email" placeholder="email" name="email" class="question__mail">
						</div>
						<textarea maxlength="1000" minlength="1" placeholder="Your text" name="text" class="question__text-box"></textarea>
					</div>
					<button class="question__send-but send-but">отправить</button>
				</form>
			</div>
		</article>
	</main>
	<footer></footer>
</body>

</html>