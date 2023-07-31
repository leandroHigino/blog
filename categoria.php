<?php 
require_once "admin/functions/db_connect.php";
require_once "admin/functions/functions.php";

require "header.php";

// Número máximo de posts por página
$postsPorPagina = 6;

// Obtém o número da página atual
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcula o offset para a consulta SQL
$offset = ($paginaAtual - 1) * $postsPorPagina;

// Obtém o ID da categoria
$idCategoria = $_GET['id'];

// Consulta para obter o nome da categoria
$sqlCategoria = "SELECT categoria FROM categorias WHERE id = '$idCategoria'";
$resultadoCategoria = mysqli_query($mysqli, $sqlCategoria);
$rowCategoria = mysqli_fetch_assoc($resultadoCategoria);
$nomeCategoria = $rowCategoria['categoria'];

// Consulta para obter o total de posts da categoria
$sqlTotalPosts = "SELECT COUNT(*) AS total FROM posts WHERE categoria = '$idCategoria'";
$resultadoTotalPosts = mysqli_query($mysqli, $sqlTotalPosts);
$rowTotalPosts = mysqli_fetch_assoc($resultadoTotalPosts);
$totalPosts = $rowTotalPosts['total'];

// Calcula o número total de páginas
$totalPaginas = ceil($totalPosts / $postsPorPagina);

// Consulta para obter os posts da categoria com limite e offset
$sqlPosts = "SELECT * FROM posts WHERE categoria = '$idCategoria' ORDER BY id DESC LIMIT $postsPorPagina OFFSET $offset";
$resultadoPosts = mysqli_query($mysqli, $sqlPosts);
?>

		<!-- page-banner section 
			================================================== -->
		<section class="page-banner-section">
			<div class="container">
				<h1>Categoria: <span>
					<?php 
						// Trazer nome da categoria
						$id = $_GET['id'];
						$sql = "SELECT categoria FROM categorias WHERE id = '$id'";
						$result = mysqli_query($mysqli, $sql);
						$row = mysqli_fetch_assoc($result);
						echo $row['categoria'];
						?>
					</span>
				</h1>
				<span> 
					<?php 
					// Trazer a quantidade de posts da categoria
					$sql = "SELECT COUNT(*) AS total FROM posts WHERE categoria = '$id'";
					$result = mysqli_query($mysqli, $sql);
					$row = mysqli_fetch_assoc($result);
					echo $row['total'];
					?>
					Posts encontrados
				</span>
			</div>
		</section>
		<!-- End page-banner section -->

		<!-- blog section 
			================================================== -->
		<section class="blog-section">
			<div class="container">
				<div class="blog-box grid-style text-center">
					<div class="row">
						<?php 
							// Query para trazer os posts de uma categoria específica
							$id = $_GET['id'];
							$sql = "SELECT * FROM posts WHERE categoria = '$id' ORDER BY id DESC";

							$result = mysqli_query($mysqli, $sql);

							while ($row = mysqli_fetch_array($resultadoPosts)) {
								$id = $row['id'];
								$titulo = $row['titulo'];
								$imagem = $row['imagem'];
								$categoria = $row['categoria'];
								$autor = $row['autor'];    
								$conteudo = $row['conteudo'];    
								$data_post = $row['data_post'];
						
								// Consulta para obter o nome da categoria com base no ID
								$query_categoria = "SELECT categoria FROM categorias WHERE id = '$categoria'";
								$result_categoria = mysqli_query($mysqli, $query_categoria);
								$row_categoria = mysqli_fetch_assoc($result_categoria);
								$categoria = $row_categoria['categoria'];
							?>
						<div class="col-lg-4 col-md-6">
							<div class="news-post article-post">
								
								<div class="image-holder">
									<?php $uploadsPath = realpath("../admin/uploads/");?>
									<img src="admin/<?php echo $imagem; ?>" alt="" style="width:100%;height:234px;object-fit: cover;">
								</div>
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
									
									<li>by <a href="#"><?php echo $autor; ?></a></li>
									<p><?php echo substr($row['conteudo'], 0, 100 ) . '...'; ?></p>
								</ul>
								
							</div>
						</div>
						<?php } ?>	
					</div>
					
					<div class="pagination-box">
						<ul class="pagination-list">
							<?php
							// Verifica se há mais de uma página
							if ($totalPaginas > 1) {
								// Verifica se não é a primeira página
								if ($paginaAtual > 1) {
									$paginaAnterior = $paginaAtual - 1;
									echo "<li><a href='?id=$idCategoria&pagina=$paginaAnterior'><i class='fa fa-angle-left'></i> Página Anterior</a></li>";
								}

								// Exibe os links das páginas
								for ($i = 1; $i <= $totalPaginas; $i++) {
									if ($i == $paginaAtual) {
										echo "<li><a href='?id=$idCategoria&pagina=$i' class='active'>$i</a></li>";
									} else {
										echo "<li><a href='?id=$idCategoria&pagina=$i'>$i</a></li>";
									}
								}

								// Verifica se não é a última página
								if ($paginaAtual < $totalPaginas) {
									$proximaPagina = $paginaAtual + 1;
									echo "<li><a href='?id=$idCategoria&pagina=$proximaPagina'>Próxima Página <i class='fa fa-angle-right'></i></a></li>";
								}
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<!-- End blog section -->

		<?php require "footer.php"; ?>