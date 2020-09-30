<?php
require_once __DIR__ . "/component/autoLoad.php";
autoLoad(__FILE__);
// выход из админки
session_start();
if (isset($_GET["exit"])) {
	session_unset();
	header("location: index.php?page=1&sort_name=name&sort_type=0");
}
if (!isset($_GET['page']) || !isset($_GET['sort_name']) || !isset($_GET['sort_type'])) header("location: index.php?page=1&sort_name=name&sort_type=0");
$page = (!isset($_GET['page']) || $_GET["page"] < 1) ? 1 : $_GET["page"];
$sortName = !isset($_GET['sort_name']) ? 'name' : $_GET['sort_name'];
$sortType = !isset($_GET['sort_type']) ? '0' : $_GET['sort_type'];
$dataPost = getInfo((int)$page, $sortName, $sortType);
$adminMod = $dataPost['adminMod'];

function getLink($page, $sortName, $sortType, $exit = false)
{
	$response = '?page=' . $page . '&sort_name=' . $sortName . '&sort_type=' . $sortType;
	if ($exit) $response .= "&exit=1";
	return $response;
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
			<h3>Вы Админ (<?php echo $_SESSION['login'] ?>)</h3>
			<a href="<?php echo getLink($page, $sortName, $sortType, true) ?>" class="exit">Выйти</a>
		<?php } ?>

	</header>
	<main>
		<article class="table-question">
			<div class="table-question__sort sort">
				<p class="sort__header">Сортировать по:</p>
				<ul class="sort__list">

					<li class="sort__element">
						<a href="<?php echo getLink($page, 'name', $sortType) ?>" class="sort__link<?php echo ($sortName == 'name') ? ' sort__link_active' : ''; ?>">Имя</a>
					</li>
					<li class="sort__element">
						<a href="<?php echo getLink($page, 'email', $sortType) ?>" class="sort__link<?php echo ($sortName == 'email') ? ' sort__link_active' : ''; ?>">Почта</a>
					</li>
					<li class="sort__element">
						<a href="<?php echo getLink($page, 'status', $sortType) ?>" class="sort__link<?php echo ($sortName == 'status') ? ' sort__link_active' : ''; ?>">Статус</a>
					</li>
					<li class="sort__element"> | </li>
					<li class="sort__element">
						<a href="<?php echo getLink($page, $sortName, "1") ?>" class="sort__link<?php echo ($sortType == '1') ? ' sort__link_active' : ''; ?>">Убывание</a>
					</li>
					<li class="sort__element">
						<a href="<?php echo getLink($page, $sortName, "0") ?>" class="sort__link<?php echo ($sortType == '0') ? ' sort__link_active' : ''; ?>">Возростание</a>
					</li>

				</ul>
			</div>

			<!-- Posts -->
			<ul class="table-question__list">
				<?php
				for ($i = 0; $i < count($dataPost['post']); $i++) {
					$post = $dataPost['post'][$i];


					if ($adminMod == 1) {
				?>
						<li class="table-question__question question">
							<form action="/controller/admin.php" method="POST">
								<div class="question__wrapper">
									<div class="question__head">

										<input class="question__name" name="name" value="<?php echo $post['name']; ?>" readonly>

										<div class="question__mail"><?php echo $post['email']; ?></div>

										<div class="question__status"><?php echo (($post['status'] == 0) ? "Не выполнено" : "Выполнено"); ?> |<input type="checkbox" name="status" <?php echo (($post['status'] == 1) ? 'checked' : ''); ?>> </div>

									</div>
									<div class="question__text-box">
										<textarea class="question__text" name="text"><?php echo $post['text']; ?></textarea>
									</div>

									<?php if ($post['edit'] == 1) { ?>
										<p class='question__edit'>Отредактировано администратором</p>
									<?php } ?>

									<button class="question__send-but">Потвердить</button>
								</div>
							</form>
						</li>


					<?php } else { ?>
						<li class="table-question__question question">
							<div class="question__wrapper">
								<div class="question__head">

									<div class="question__name"><?php echo $post['name']; ?></div>

									<div class="question__mail"><?php echo $post['email']; ?></div>

									<div class="question__status"><?php echo (($post['status'] == 0) ? "Не выполнено" : "Выполнено"); ?></div>

								</div>
								<div class="question__text-box">

									<p class="question__text"><?php echo $post['text'] ?></p>

								</div>
								<?php if ($post['edit'] == 1) { ?>
									<p class='question__edit'>Отредактировано администратором</p>
								<?php } ?>

							</div>
						</li>
				<?php }
				}
				?>
			</ul>

			<!-- pagination -->
			<div class="table-question__pagination pagination">
				<ul class="pagination__list">
					<?php
					for ($i = 0; $i < $dataPost['page']; $i++) { ?>
						<li class="pagination__element">
							<a href="<?php echo getLink($i + 1, $sortName, $sortType); ?>" class="pagination__link"><?php echo ($i + 1); ?></a>
						</li>
					<?php } ?>
				</ul>
			</div>

			<!-- add post -->
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