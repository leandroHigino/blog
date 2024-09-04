<?php
require_once "admin/functions/db_connect.php";
require_once "admin/functions/functions.php";

// Criar uma instância da classe CategoriasManager
$categoriasManager = new CategoriasManager();

// Obter as categorias do banco de dados
$categorias = $categoriasManager->fetchCategorias();

require "header.php";

?>

<!-- blog section 
			================================================== -->
<section class="blog-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="single-post">
					<div class="single-post-content">
						<?php
						// Receber o ID do post enviado pela URL
						$slug = $_GET['slug'];

						// Consulta para obter os dados do post com base no ID
						$query = "SELECT * FROM posts WHERE slug = '$slug'";

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
							$slug      = $row['slug'];

							// Consulta para obter o nome da categoria com base no ID
							$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
							$result_categoria = mysqli_query($mysqli, $query_categoria);
							$row_categoria = mysqli_fetch_assoc($result_categoria);
							$categoria = $row_categoria['categoria'];



						?>
							<?php $uploadsPath = realpath("../admin/uploads/"); ?>
							<img src="admin/<?php echo $imagem; ?>" alt="">

							<div class="post-content">
								<div class="post-content-text">

									<h1><?php echo $titulo; ?></h1>
									<ul class="post-tags">
										<li>Categoria: <a class="text-link" href="#"><?php echo $categoria; ?></a></li>
										<li>Autor: <a class="text-link" href="#"><?php echo $autor; ?></a></li>
										<li>
											<?php
											$data = $row['data_post'];
											$data = date("d/m/Y", strtotime($data));
											echo $data;
											?>
										</li>
									</ul>
									<p>
										<?php echo $conteudo; ?>
									</p>


								</div>
							</div>
							<div class="prev-next-box">
								<?php
								// Consulta para obter o post anterior
								$query_anterior = "SELECT id, slug, titulo FROM posts WHERE id < '$id' AND categoria IN (SELECT id FROM categorias WHERE categoria = '$categoria') ORDER BY id DESC LIMIT 1";
								$result_anterior = mysqli_query($mysqli, $query_anterior);
								$post_anterior = mysqli_fetch_assoc($result_anterior);

								// Consulta para obter o próximo post
								$query_proximo = "SELECT id, slug, titulo FROM posts WHERE id > '$id' AND categoria IN (SELECT id FROM categorias WHERE categoria = '$categoria') ORDER BY id ASC LIMIT 1";
								$result_proximo = mysqli_query($mysqli, $query_proximo);
								$post_proximo = mysqli_fetch_assoc($result_proximo);
								?>
								<div class="prev-box">
									<?php if ($post_anterior) { ?>
										<a class="text-link" href="post?slug=<?php echo $post_anterior['slug']; ?>"><i class="fa fa-angle-left"></i> Post Anterior</a>
										<h2><a href="post?slug=<?php echo $post_anterior['slug']; ?>"><?php echo $post_anterior['titulo']; ?></a></h2>
									<?php } ?>
								</div>
								<div class="next-box">
									<?php if ($post_proximo) { ?>
										<a class="text-link next-link" href="post?slug=<?php echo $post_proximo['slug']; ?>">Próximo Post <i class="fa fa-angle-right"></i></a>
										<h2><a href="post?slug=<?php echo $post_proximo['slug']; ?>"><?php echo $post_proximo['titulo']; ?></a></h2>
									<?php } ?>
								</div>
							</div>




							<div class="related-box">
								<h2>Posts Relacionados</h2>
								<div class="row">
									<?php
									// Consulta para obter a categoria do post atual
									$query_categoria_atual = "SELECT categoria FROM posts WHERE id = '$id'";
									$result_categoria_atual = mysqli_query($mysqli, $query_categoria_atual);
									$row_categoria_atual = mysqli_fetch_assoc($result_categoria_atual);
									$categoria_atual = $row_categoria_atual['categoria'];

									// Consulta para obter os dados dos posts relacionados
									$query = "SELECT * FROM posts WHERE categoria = '$categoria_atual' AND id != '$id' LIMIT 6";
									$result = mysqli_query($mysqli, $query);

									if (mysqli_num_rows($result) > 0) {
										while ($row = mysqli_fetch_assoc($result)) {
											$id        = $row['id'];
											$titulo    = $row['titulo'];
											$autor     = $row['autor'];
											$slug      = $row['slug']; // Obtendo o slug do post
											$categoria = $row['categoria'];
											$data_post = $row['data_post'];
											$imagem    = $row['imagem'];

											// Consulta para obter o nome da categoria com base no ID
											$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
											$result_categoria = mysqli_query($mysqli, $query_categoria);
											$row_categoria = mysqli_fetch_assoc($result_categoria);
											$categoria_nome = $row_categoria['categoria'];
									?>
											<div class="col-lg-4 col-md-4">
												<div class="news-post standard-post text-left" style="margin-bottom: 20px;">
													<div class="image-holder">
														<?php $uploadsPath = realpath("../admin/uploads/"); ?>
														<img src="admin/<?php echo $imagem; ?>" alt="" style="width:100%;height:114px;object-fit: cover;">
													</div>
													<a class="text-link" href="#"><?php echo $categoria_nome; ?></a>
													<h2><a href="post?slug=<?php echo $slug; ?>"><?php echo $titulo; ?></a></h2> <!-- Link usando o slug -->
													<ul class="post-tags">
														<li>by <a href="#"><?php echo $autor; ?></a></li>
														<li>
															<?php
															$data = $row['data_post'];
															$data = date("d/m/Y", strtotime($data));
															echo $data;
															?>
														</li>
													</ul>
												</div>
											</div>
											<br>
									<?php
										}
									} else {
										echo "<p>Nenhum post relacionado encontrado.</p>";
									}
									?>
								</div>
							</div>

					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="sidebar">

					<div class="widget social-widget">
						<h2>Redes Sociais</h2>
						<ul class="social-list">
							<li><a href="#"><i class="fa fa-instagram"></i>instagram</a></li>
							<li><a href="#"><i class="fa fa-facebook"></i>facebook</a></li>
						</ul>
					</div>

					<div class="widget category-widget">
						<h2>Categorias</h2>
						<ul class="category-list">

							<?php

							function slugify($string)
							{
								// Substituir caracteres especiais por hífens
								$string = preg_replace('/[^\p{L}\p{N}]+/u', '-', $string);

								// Remover espaços em branco adicionais
								$string = trim($string, '-');

								// Converter para letras minúsculas
								$string = mb_strtolower($string);

								return $string;
							}
							//Trazer as categorias do banco de dados e contar quantos posts tem em cada uma delas
							$sql = "SELECT c.id, c.categoria, COUNT(p.id) AS qtde_posts
											FROM categorias c
											LEFT JOIN posts p ON c.id = p.categoria
											GROUP BY c.id, c.categoria";
							$resultado = mysqli_query($mysqli, $sql);

							while ($dados = mysqli_fetch_array($resultado)) {
								$id = $dados['id'];
								$categoria = $dados['categoria'];
								$qtde = $dados['qtde_posts'];

								// Gerar o slug da categoria
								$slug = slugify($categoria); // Supondo que você tenha uma função slugify()

								echo "<li>
												<a href='categoria?id=$id'>
													$categoria <span>$qtde</span>
												</a>
											</li>";
							?>
							<?php } ?>
						</ul>
					</div>

					<div class="widget list-widget">
						<h2>Leia também</h2>
						<ul class="list-posts">
							<?php
							// Consulta para obter todas as categorias
							$result_categorias = mysqli_query($mysqli, "SELECT id, categoria FROM categorias");

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
		<?php } ?>
		</div>
	</div>
</section>
<!-- End blog section -->

<?php require "footer.php"; ?>