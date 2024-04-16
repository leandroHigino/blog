<?php
require_once "admin/functions/db_connect.php";
require_once "admin/functions/functions.php";
require_once "header.php";
?>

<!-- trending-section 
		================================================== -->
<section class="trending-section">
	<div class="container">
		<div class="title-section">
			<div class="row">
				<div class="col-md-12">
					<h1>Posts em Destaque</h1>
				</div>
			</div>
		</div>

		<div class="trending-box">
			<div class="row">
				<div class="col-lg-6">

					<div class="owl-wrapper">

						<div class="owl-carousel" data-num="1">
							<?php
							// Consulta para obter os posts em destaque
							$query = "SELECT * FROM posts WHERE destaque = 1 ORDER BY data_post DESC LIMIT 3";
							$result = mysqli_query($mysqli, $query);

							while ($row = mysqli_fetch_assoc($result)) {
								$id        = $row['id'];
								$titulo    = $row['titulo'];
								$autor     = $row['autor'];
								$categoria = $row['categoria'];
								$data_post = $row['data_post'];
								$imagem    = $row['imagem'];
								$conteudo  = $row['conteudo'];
								$destaque  = $row['destaque'];
								$slug 	= $row['slug'];

								// Consulta para obter o nome da categoria com base no ID
								$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
								$result_categoria = mysqli_query($mysqli, $query_categoria);
								$row_categoria = mysqli_fetch_assoc($result_categoria);
								$categoria = $row_categoria['categoria'];

							?>
								<div class="item">

									<div class="news-post image-post">
										<?php $uploadsPath = realpath("../admin/uploads/"); ?>
										<img src="admin/<?php echo $imagem; ?>" alt="" style="width:100%;height:540px;object-fit: cover;">

										<div class="hover-post overlay-bg">
											<a class="category-link" href="#"><?php echo $categoria; ?></a>
											<h2><a href="post?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></h2>
											<ul class="post-tags">
												<li>by <a href="#"><?php echo $autor; ?></a></li>
												<li><?php
													$data = $row['data_post'];
													$data = date("d/m/Y", strtotime($data));
													echo $data;
													?>
												</li>
											</ul>
											<p></p>
										</div>

									</div>

								</div>
							<?php } ?>
						</div>

					</div>

				</div>

				<div class="col-lg-3 col-md-6">
					<ul class="posts-list">
						<li>
							<?php
							// Trazer o post mais recente da categoria futebol
							$query = "SELECT * FROM posts WHERE categoria = 1 ORDER BY data_post DESC LIMIT 1";
							$result = mysqli_query($mysqli, $query);

							while ($row = mysqli_fetch_assoc($result)) {
								$id        = $row['id'];
								$titulo    = $row['titulo'];
								$categoria = $row['categoria'];
								$data_post = $row['data_post'];

								// Consulta para obter o nome da categoria com base no ID
								$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
								$result_categoria = mysqli_query($mysqli, $query_categoria);
								$row_categoria = mysqli_fetch_assoc($result_categoria);
								$categoria = $row_categoria['categoria'];

							?>
								<a class="text-link" href="#"><?php echo $categoria; ?></a>
								<h2><a href="post?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></h2>
								<ul class="post-tags">
									<li>
										<?php
										$data_inicial = new DateTime($data_post);
										$data_atual = new DateTime(); // Data atual
										$intervalo = $data_inicial->diff($data_atual);
										echo $intervalo->format('Publicado à %a dias'); // Mostra a diferença em dias
										?>
									</li>
								</ul>
							<?php
							}
							?>

						</li>
						<li>
							<?php
							// Trazer o post mais recente da categoria futebol
							$query = "SELECT * FROM posts WHERE categoria = 2 ORDER BY data_post DESC LIMIT 1";
							$result = mysqli_query($mysqli, $query);

							while ($row = mysqli_fetch_assoc($result)) {

								$id        = $row['id'];
								$titulo    = $row['titulo'];
								$categoria = $row['categoria'];
								$data_post = $row['data_post'];

								// Consulta para obter o nome da categoria com base no ID
								$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
								$result_categoria = mysqli_query($mysqli, $query_categoria);
								$row_categoria = mysqli_fetch_assoc($result_categoria);
								$categoria = $row_categoria['categoria'];


							?>
								<a class="text-link" href="#"><?php echo $categoria; ?></a>
								<h2><a href="post?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></h2>
								<ul class="post-tags">
									<li>
										<?php
										$data_inicial = new DateTime($data_post);
										$data_atual = new DateTime(); // Data atual
										$intervalo = $data_inicial->diff($data_atual);
										echo $intervalo->format('Publicado à %a dias'); // Mostra a diferença em dias
										?>
									</li>
								</ul>
							<?php } ?>
						</li>
						<li>
							<?php
							// Trazer o post mais recente da categoria futebol
							$query = "SELECT * FROM posts WHERE categoria = 3 ORDER BY data_post DESC LIMIT 1";
							$result = mysqli_query($mysqli, $query);

							while ($row = mysqli_fetch_assoc($result)) {

								$id        = $row['id'];
								$titulo    = $row['titulo'];
								$categoria = $row['categoria'];
								$data_post = $row['data_post'];

								// Consulta para obter o nome da categoria com base no ID
								$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
								$result_categoria = mysqli_query($mysqli, $query_categoria);
								$row_categoria = mysqli_fetch_assoc($result_categoria);
								$categoria = $row_categoria['categoria'];


							?>
								<a class="text-link" href="#"><?php echo $categoria; ?></a>
								<h2><a href="post?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></h2>
								<ul class="post-tags">
									<li>
										<?php
										$data_inicial = new DateTime($data_post);
										$data_atual = new DateTime(); // Data atual
										$intervalo = $data_inicial->diff($data_atual);
										echo $intervalo->format('Publicado à %a dias'); // Mostra a diferença em dias
										?>
									</li>
								</ul>
							<?php } ?>
						</li>
						<li>
							<?php
							// Trazer o post mais recente da categoria futebol
							$query = "SELECT * FROM posts WHERE categoria = 4 ORDER BY data_post DESC LIMIT 1";
							$result = mysqli_query($mysqli, $query);

							while ($row = mysqli_fetch_assoc($result)) {

								$id        = $row['id'];
								$titulo    = $row['titulo'];
								$categoria = $row['categoria'];
								$data_post = $row['data_post'];

								// Consulta para obter o nome da categoria com base no ID
								$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
								$result_categoria = mysqli_query($mysqli, $query_categoria);
								$row_categoria = mysqli_fetch_assoc($result_categoria);
								$categoria = $row_categoria['categoria'];


							?>
								<a class="text-link" href="#"><?php echo $categoria; ?></a>
								<h2><a href="post?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></h2>
								<ul class="post-tags">
									<li>
										<?php
										$data_inicial = new DateTime($data_post);
										$data_atual = new DateTime(); // Data atual
										$intervalo = $data_inicial->diff($data_atual);
										echo $intervalo->format('Publicado à %a dias'); // Mostra a diferença em dias
										?>
									</li>
								</ul>
							<?php } ?>
						</li>
					</ul>
				</div>

				<div class="col-lg-3 col-md-6">
					<div class="news-post image-post">
						<img src="upload/blog/sa1.jpg" alt="" style="width:100%;height: 540px;object-fit: cover;">
					</div>
				</div>

			</div>


		</div>

	</div>
</section>
<!-- End trending section -->



<!-- fresh-section 
			================================================== -->
<section class="fresh-section">
	<div class="container">
		<div class="title-section text-center">
			<h1>Posts Recentes</h1>
		</div>
		<div class="fresh-box owl-wrapper">

			<div class="owl-carousel" data-num="4">
				<?php
				$query = "SELECT * FROM posts ORDER BY data_post DESC";
				$result = mysqli_query($mysqli, $query);

				$result = mysqli_query($mysqli, $query);

				while ($row = mysqli_fetch_assoc($result)) {
					$id        = $row['id'];
					$titulo    = $row['titulo'];
					$autor     = $row['autor'];
					$categoria = $row['categoria'];
					$data_post = $row['data_post'];
					$imagem    = $row['imagem'];
					$conteudo  = $row['conteudo'];
					$destaque  = $row['destaque'];

					// Consulta para obter o nome da categoria com base no ID
					$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
					$result_categoria = mysqli_query($mysqli, $query_categoria);
					$row_categoria = mysqli_fetch_assoc($result_categoria);
					$categoria = $row_categoria['categoria'];
				?>

					<div class="item">
						<div class="news-post standard-post">
							<div class="image-holder">
								<?php $uploadsPath = realpath("../admin/uploads/"); ?>
								<img src="admin/<?php echo $imagem; ?>" alt="" style="width:100%;height:180px;object-fit: cover;">
							</div>
							<a class="category-link" style="color:white;"><?php echo $categoria; ?></a>
							<h2><a href="post?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></h2>
							<ul class="post-tags">
								<li>
									<?php
									$data_inicial = new DateTime($data_post);
									$data_atual = new DateTime(); // Data atual
									$intervalo = $data_inicial->diff($data_atual);
									echo $intervalo->format('Publicado à %a dias'); // Mostra a diferença em dias
									?>
								</li>
								<li>by <a href="#"><?php echo $autor; ?></a></li>
							</ul>
						</div>
					</div>

				<?php } ?>

			</div>
		</div>
		<div class="border-bottom"></div>
	</div>
</section>
<!-- End fresh section -->


<!-- blog section 
			================================================== -->
<section class="blog-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="blog-box">
					<div class="title-section">
						<h1>Últimos Posts</h1>
					</div>
					<div class="iso-call">
						<div class="item">
							<?php
							// Trazer o post mais recente da categoria futebol
							$query = "SELECT * FROM posts WHERE categoria = 1 ORDER BY data_post DESC LIMIT 1";
							$result = mysqli_query($mysqli, $query);

							while ($row = mysqli_fetch_assoc($result)) {
								$id        = $row['id'];
								$titulo    = $row['titulo'];
								$autor     = $row['autor'];
								$categoria = $row['categoria'];
								$data_post = $row['data_post'];
								$imagem    = $row['imagem'];
								$conteudo  = $row['conteudo'];
								$destaque  = $row['destaque'];

								// Consulta para obter o nome da categoria com base no ID
								$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
								$result_categoria = mysqli_query($mysqli, $query_categoria);
								$row_categoria = mysqli_fetch_assoc($result_categoria);
								$categoria = $row_categoria['categoria'];


							?>
								<div class="news-post article-post">
									<div class="image-holder">
										<?php $uploadsPath = realpath("../admin/uploads/"); ?>
										<img src="admin/<?php echo $imagem; ?>" alt="" style="width:100%;height:234px;object-fit: cover;">
									</div>
									<a class="text-link" href="#"><?php echo $categoria; ?></a>
									<h2><a href="post?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></h2>
									<ul class="post-tags">
										<li><?php
											$data_inicial = new DateTime($data_post);
											$data_atual = new DateTime(); // Data atual
											$intervalo = $data_inicial->diff($data_atual);
											echo $intervalo->format('Publicado à %a dias'); // Mostra a diferença em dias
											?>
										</li>
										<li>by <a href="#"><?php echo $autor; ?></a></li>
									</ul>
									<p><?php echo substr($row['conteudo'], 0, 45); ?></p>
								</div>
							<?php } ?>
						</div>
						<div class="item">
							<?php
							// Trazer o post mais recente da categoria nba
							$query = "SELECT * FROM posts WHERE categoria = 2 ORDER BY data_post DESC LIMIT 1";
							$result = mysqli_query($mysqli, $query);

							while ($row = mysqli_fetch_assoc($result)) {
								$id        = $row['id'];
								$titulo    = $row['titulo'];
								$autor     = $row['autor'];
								$categoria = $row['categoria'];
								$data_post = $row['data_post'];
								$imagem    = $row['imagem'];
								$conteudo  = $row['conteudo'];
								$destaque  = $row['destaque'];

								// Consulta para obter o nome da categoria com base no ID
								$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
								$result_categoria = mysqli_query($mysqli, $query_categoria);
								$row_categoria = mysqli_fetch_assoc($result_categoria);
								$categoria = $row_categoria['categoria'];


							?>
								<div class="news-post article-post">
									<div class="image-holder">
										<?php $uploadsPath = realpath("../admin/uploads/"); ?>
										<img src="admin/<?php echo $imagem; ?>" alt="" style="width:100%;height:234px;object-fit: cover;">
									</div>
									<a class="text-link" href="#"><?php echo $categoria; ?></a>
									<h2><a href="post?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></h2>
									<ul class="post-tags">
										<li><?php
											$data_inicial = new DateTime($data_post);
											$data_atual = new DateTime(); // Data atual
											$intervalo = $data_inicial->diff($data_atual);
											echo $intervalo->format('Publicado à %a dias'); // Mostra a diferença em dias
											?>
										</li>
										<li>by <a href="#"><?php echo $autor; ?></a></li>
									</ul>
									<p><?php echo substr($row['conteudo'], 0, 45); ?></p>
								</div>
							<?php } ?>
						</div>
						<div class="item">
							<?php
							// Trazer o post mais recente da categoria F1
							$query = "SELECT * FROM posts WHERE categoria = 3 ORDER BY data_post DESC LIMIT 1";
							$result = mysqli_query($mysqli, $query);

							while ($row = mysqli_fetch_assoc($result)) {
								$id        = $row['id'];
								$titulo    = $row['titulo'];
								$autor     = $row['autor'];
								$categoria = $row['categoria'];
								$data_post = $row['data_post'];
								$imagem    = $row['imagem'];
								$conteudo  = $row['conteudo'];
								$destaque  = $row['destaque'];

								// Consulta para obter o nome da categoria com base no ID
								$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
								$result_categoria = mysqli_query($mysqli, $query_categoria);
								$row_categoria = mysqli_fetch_assoc($result_categoria);
								$categoria = $row_categoria['categoria'];


							?>
								<div class="news-post article-post">
									<div class="image-holder">
										<?php $uploadsPath = realpath("../admin/uploads/"); ?>
										<img src="admin/<?php echo $imagem; ?>" alt="" style="width:100%;height:234px;object-fit: cover;">
									</div>
									<a class="text-link" href="#"><?php echo $categoria; ?></a>
									<h2><a href="post?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></h2>
									<ul class="post-tags">
										<li><?php
											$data_inicial = new DateTime($data_post);
											$data_atual = new DateTime(); // Data atual
											$intervalo = $data_inicial->diff($data_atual);
											echo $intervalo->format('Publicado à %a dias'); // Mostra a diferença em dias
											?>
										</li>
										<li>by <a href="#"><?php echo $autor; ?></a></li>
									</ul>
									<p><?php echo substr($row['conteudo'], 0, 45); ?></p>
								</div>
							<?php } ?>
						</div>
						<div class="item">
							<?php
							// Trazer o post mais recente da categoria skate
							$query = "SELECT * FROM posts WHERE categoria = 4 ORDER BY data_post DESC LIMIT 1";
							$result = mysqli_query($mysqli, $query);

							while ($row = mysqli_fetch_assoc($result)) {
								$id        = $row['id'];
								$titulo    = $row['titulo'];
								$autor     = $row['autor'];
								$categoria = $row['categoria'];
								$data_post = $row['data_post'];
								$imagem    = $row['imagem'];
								$conteudo  = $row['conteudo'];
								$destaque  = $row['destaque'];

								// Consulta para obter o nome da categoria com base no ID
								$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
								$result_categoria = mysqli_query($mysqli, $query_categoria);
								$row_categoria = mysqli_fetch_assoc($result_categoria);
								$categoria = $row_categoria['categoria'];
							?>
								<div class="news-post article-post">
									<div class="image-holder">
										<?php $uploadsPath = realpath("../admin/uploads/"); ?>
										<img src="admin/<?php echo $imagem; ?>" alt="" style="width:100%;height:234px;object-fit: cover;">
									</div>
									<a class="text-link" href="#"><?php echo $categoria; ?></a>
									<h2><a href="post?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></h2>
									<ul class="post-tags">
										<li><?php
											$data_inicial = new DateTime($data_post);
											$data_atual = new DateTime(); // Data atual
											$intervalo = $data_inicial->diff($data_atual);
											echo $intervalo->format('Publicado à %a dias'); // Mostra a diferença em dias
											?>
										</li>
										<li>by <a href="#"><?php echo $autor; ?></a></li>
									</ul>
									<p><?php echo substr($row['conteudo'], 0, 100); ?></p>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="sidebar">
					<div class="widget social-widget">
						<h2>Social</h2>
						<ul class="social-list">
							<li>
								<a href="#">
									<i class="fa fa-facebook"></i>
									facebook
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fa fa-twitter"></i>
									twitter
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fa fa-instagram"></i>
									instagram
								</a>
							</li>
						</ul>
					</div>

					<div class="widget list-widget">
						<h2>Leia também</h2>
						<ul class="list-posts">
							<?php
							// Consulta para obter todos os posts da categoria futebol
							$query = "SELECT p.id, p.titulo, p.categoria, p.data_post, c.categoria AS categoria
											FROM posts p
											INNER JOIN categorias c ON p.categoria = c.id
											WHERE c.categoria = 'futebol'
											ORDER BY p.data_post DESC LIMIT 6";
							$result = mysqli_query($mysqli, $query);

							while ($row = mysqli_fetch_assoc($result)) {
								$id = $row['id'];
								$titulo = $row['titulo'];
								$data_post = $row['data_post'];
								$categoria = $row['categoria'];
							?>
								<li>
									<a class="text-link" href="#"><?php echo $categoria; ?></a>
									<h2><a href="post?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></h2>
									<ul class="post-tags">
										<li>
											<?php
											$data_inicial = new DateTime($data_post);
											$data_atual = new DateTime(); // Data atual
											$intervalo = $data_inicial->diff($data_atual);
											echo $intervalo->format('Publicado à %a dias'); // Mostra a diferença em dias
											?>
										</li>
									</ul>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End blog section -->

<?php require "footer.php"; ?>