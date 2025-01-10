<?php
require_once "admin/functions/db_connect.php";
require_once "admin/functions/functions.php";

// Instancia a classe Publicidade
$publicidade = new Publicidade();

// Busca todas as publicidades
$publicidades = $publicidade->fetchAll();
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
								$video     = $row['video']; // Campo de vídeo
								$slug 	   = $row['slug'];

								// Consulta para obter o nome da categoria com base no ID
								$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
								$result_categoria = mysqli_query($mysqli, $query_categoria);
								$row_categoria = mysqli_fetch_assoc($result_categoria);
								$categoria = $row_categoria['categoria'];
							?>
								<div class="item">
									<div class="news-post image-post">
										<?php if ($video): ?>
											<!-- Exibir o vídeo se houver, com altura definida -->
											<video style="width:100%;height:540px;object-fit:cover;">
												<source src="admin/<?php echo $video; ?>" type="video/mp4">
												Seu navegador não suporta o elemento de vídeo.
											</video>
										<?php elseif ($imagem): ?>
											<!-- Exibir a imagem se houver -->
											<img src="admin/<?php echo $imagem; ?>" alt="" style="width:100%;height:540px;object-fit:cover;">
										<?php endif; ?>
										<div class="hover-post overlay-bg">
											<a class="category-link" href="#"><?php echo $categoria; ?></a>
											<h2><a href="post?slug=<?php echo $slug; ?>"><?php echo $titulo; ?></a></h2>
											<ul class="post-tags">
												<li>by <a href="#"><?php echo $autor; ?></a></li>
												<li><?php echo date("d/m/Y", strtotime($data_post)); ?></li>
											</ul>
										</div>
									</div>
								</div>
							<?php } ?>

						</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-6">
					<ul class="posts-list">
						<?php
						// Passo 1: Obter a lista de categorias
						$query_categorias = "SELECT id, categoria FROM categorias";
						$result_categorias = mysqli_query($mysqli, $query_categorias);

						// Passo 2: Para cada categoria, obter o post mais recente
						while ($row_categoria = mysqli_fetch_assoc($result_categorias)) {
							$categoria_id = $row_categoria['id'];
							$categoria_nome = $row_categoria['categoria'];

							// Consulta para obter o post mais recente da categoria atual
							$query_posts = "
								SELECT p.id, p.titulo, p.data_post, p.slug, p.imagem, p.video
								FROM posts p
								WHERE p.categoria = ?
								ORDER BY p.data_post DESC
								LIMIT 1
							";
							$stmt_posts = $mysqli->prepare($query_posts);
							$stmt_posts->bind_param("i", $categoria_id);
							$stmt_posts->execute();
							$result_posts = $stmt_posts->get_result();

							if ($row_post = $result_posts->fetch_assoc()) {
								$titulo    = $row_post['titulo'];
								$data_post = $row_post['data_post'];
								$slug      = $row_post['slug'];
								$imagem    = $row_post['imagem'];
								$video     = $row_post['video']; // Adicionando campo de vídeo
						?>
								<li>
									<a class="text-link" href="#"><?php echo htmlspecialchars($categoria_nome); ?></a>
									<h2><a href="post?slug=<?php echo urlencode($slug); ?>"><?php echo htmlspecialchars($titulo); ?></a></h2>
									<ul class="post-tags">
										<li>
											<?php
											$data_inicial = new DateTime($data_post);
											$data_atual = new DateTime(); // Data atual
											$intervalo = $data_inicial->diff($data_atual);
											echo 'Publicado à ' . $intervalo->format('%a dias'); // Mostra a diferença em dias
											?>
										</li>
									</ul>
								</li>
						<?php
							}
						}
						?>
					</ul>
				</div>

				<div class="col-lg-3 col-md-6">
					<div class="row">
						<?php foreach ($publicidades as $item): ?>
							<div class="col-lg-12">
								<div class="news-post image-post">
									<span>Publicidade</span>
									<img src="admin/<?php echo $item['imagem']; ?>" alt="Publicidade" style="width:100%;height:540px;object-fit: cover;">
								</div>
							</div>
						<?php endforeach; ?>
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
				// Consulta para selecionar todos os posts ordenados pela data de publicação de forma decrescente
				$query = "SELECT p.*, c.categoria AS categoria_nome FROM posts p 
						  JOIN categorias c ON p.categoria = c.id 
						  ORDER BY p.id DESC";
				$result = mysqli_query($mysqli, $query);

				while ($row = mysqli_fetch_assoc($result)) {
					$id           = $row['id'];
					$titulo       = $row['titulo'];
					$autor        = $row['autor'];
					$categoria_nome = $row['categoria_nome'];
					$data_post    = $row['data_post'];
					$imagem       = $row['imagem'];
					$video        = $row['video']; // Adicionando campo de vídeo
					$conteudo     = $row['conteudo'];
					$destaque     = $row['destaque'];
					$slug         = $row['slug'];
				?>

					<div class="item">
						<div class="news-post standard-post">
							<div class="image-holder">
								<?php if ($video): ?>
									<!-- Exibe o vídeo se estiver presente -->
									<video style="width:100%;height:180px;object-fit: cover;">
										<source src="admin/<?php echo $video; ?>" type="video/mp4">
										Seu navegador não suporta o elemento de vídeo.
									</video>
								<?php elseif ($imagem): ?>
									<!-- Exibe a imagem se estiver presente -->
									<img src="admin/<?php echo $imagem; ?>" alt="" style="width:100%;height:180px;object-fit: cover;">
								<?php endif; ?>
							</div>
							<a class="category-link" style="color:white;"><?php echo $categoria_nome; ?></a>
							<h2><a href="post?slug=<?php echo $slug; ?>"><?php echo $titulo; ?></a></h2>
							<ul class="post-tags">
								<li>
									<?php
									$data_inicial = new DateTime($data_post);
									$data_atual = new DateTime(); // Data atual
									$intervalo = $data_inicial->diff($data_atual);
									echo $intervalo->format('Publicado há %a dias'); // Mostra a diferença em dias
									?>
								</li>
								<li>por <a href="#"><?php echo $autor; ?></a></li>
							</ul>
						</div>
					</div>

				<?php } ?>

			</div>
		</div>
		<!-- <div class="border-bottom"></div> -->
	</div>
</section>



<!-- End fresh section -->


<!-- blog section 
			================================================== -->
<section class="blog-section">
	<div class="container">
		<div class="row">
			<!-- Coluna para os posts -->
			<div class="col-lg-8">
				<div class="blog-box">
					<div class="title-section">
						<h1>Últimos Posts</h1>
					</div>
					<div class="iso-call">

						<?php
						// Consulta para obter as últimas postagens de cada categoria em ordem decrescente
						$query_categorias = "SELECT id, categoria FROM categorias ORDER BY id DESC";
						$result_categorias = mysqli_query($mysqli, $query_categorias);

						// Loop através de cada categoria
						while ($row_categoria = mysqli_fetch_assoc($result_categorias)) {
							$categoria_id = $row_categoria['id'];
							$categoria_nome = $row_categoria['categoria'];

							// Consulta para obter o último post da categoria atual
							$query_ultimo_post = "SELECT * FROM posts WHERE categoria = $categoria_id ORDER BY id DESC LIMIT 1";
							$result_ultimo_post = mysqli_query($mysqli, $query_ultimo_post);
							$row_ultimo_post = mysqli_fetch_assoc($result_ultimo_post);

							if ($row_ultimo_post) {
								// Dados do último post encontrado nesta categoria
								$id = $row_ultimo_post['id'];
								$titulo = $row_ultimo_post['titulo'];
								$autor = $row_ultimo_post['autor'];
								$data_post = $row_ultimo_post['data_post'];
								$imagem = $row_ultimo_post['imagem'];
								$video = $row_ultimo_post['video']; // Adicionando campo de vídeo
								$conteudo = $row_ultimo_post['conteudo'];
								$slug = $row_ultimo_post['slug'];

								// Calcular dias passados desde a publicação
								$data_inicial = new DateTime($data_post);
								$data_atual = new DateTime();
								$intervalo = $data_inicial->diff($data_atual);
								$dias_passados = $intervalo->days;
						?>

								<div class="item">
									<div class="news-post article-post">
										<div class="image-holder">
											<?php if ($video): ?>
												<!-- Exibe o vídeo se estiver presente -->
												<video style="width:100%;height:234px;object-fit: cover;">
													<source src="admin/<?php echo htmlspecialchars($video); ?>" type="video/mp4">
													Seu navegador não suporta o elemento de vídeo.
												</video>
											<?php elseif ($imagem): ?>
												<!-- Exibe a imagem se estiver presente -->
												<img src="admin/<?php echo htmlspecialchars($imagem); ?>" alt="" style="width:100%;height:234px;object-fit: cover;">
											<?php endif; ?>
										</div>
										<a class="text-link" href="#"><?php echo htmlspecialchars($categoria_nome); ?></a>
										<h2><a href="post?slug=<?php echo urlencode($slug); ?>"><?php echo htmlspecialchars($titulo); ?></a></h2>
										<ul class="post-tags">
											<li>Publicado há <?php echo $dias_passados; ?> dias</li>
											<li>by <a href="#"><?php echo htmlspecialchars($autor); ?></a></li>
										</ul>
										<p><?php echo nl2br(htmlspecialchars_decode(substr(strip_tags($conteudo), 0, 30))); ?></p>
									</div>
								</div>

						<?php
							}
						}
						?>

					</div>
				</div>
			</div>

			<!-- Coluna da barra lateral -->
			<div class="col-lg-4">
				<div class="sidebar">
					<div class="widget social-widget">
						<h2>Social</h2>
						<ul class="social-list">
							<li><a href="#"><i class="fa fa-instagram"></i>instagram</a></li>
							<li><a href="#"><i class="fa fa-facebook"></i>facebook</a></li>
						</ul>
					</div>

					<div class="widget list-widget">
						<h2>Leia também</h2>
						<ul class="list-posts">
							<?php
							// Consulta para obter todas as categorias em ordem decrescente
							$result_categorias = mysqli_query($mysqli, "SELECT id, categoria FROM categorias ORDER BY id DESC");

							// Iterar sobre cada categoria
							while ($row_categoria = mysqli_fetch_assoc($result_categorias)) {
								$categoria_id = $row_categoria['id'];
								$categoria_nome = $row_categoria['categoria'];

								// Consulta para obter os 6 posts mais recentes da categoria atual
								$stmt_posts = $mysqli->prepare("SELECT id, titulo, data_post, slug FROM posts WHERE categoria = ? ORDER BY data_post DESC LIMIT 1");
								$stmt_posts->bind_param("i", $categoria_id);
								$stmt_posts->execute();
								$result_posts = $stmt_posts->get_result();

								// Exibir posts da categoria atual
								while ($row_post = $result_posts->fetch_assoc()) {
									$id = $row_post['id'];
									$titulo = $row_post['titulo'];
									$data_post = $row_post['data_post'];
									$slug = $row_post['slug']; // Recupera o slug corretamente
							?>
									<li>
										<a class="text-link" href="#"><?php echo htmlspecialchars($categoria_nome); ?></a>
										<h2><a href="post?slug=<?php echo urlencode($slug); ?>"><?php echo htmlspecialchars($titulo); ?></a></h2>
										<ul class="post-tags">
											<li>
												<?php
												$data_inicial = new DateTime($data_post);
												$data_atual = new DateTime();
												$intervalo = $data_inicial->diff($data_atual);
												echo 'Publicado há ' . $intervalo->format('%a dias');
												?>
											</li>
										</ul>
									</li>
							<?php
								}
								$stmt_posts->close();
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- End blog section -->

<?php require "footer.php"; ?>