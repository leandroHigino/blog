<?php
require_once "admin/functions/db_connect.php";
require_once "admin/functions/functions.php";

require "header.php";

// Número máximo de posts por página
$postsPorPagina = 6;

// Obtém o nome da categoria da URL
$nomeCategoria = $_GET['categoria'];

// Consulta para obter o ID da categoria
$sqlCategoria = "SELECT id FROM categorias WHERE categoria = '$nomeCategoria'";
$resultadoCategoria = mysqli_query($mysqli, $sqlCategoria);
$rowCategoria = mysqli_fetch_assoc($resultadoCategoria);
$idCategoria = $rowCategoria['id'];

// Obtém o número da página atual
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcula o offset para a consulta SQL
$offset = ($paginaAtual - 1) * $postsPorPagina;

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

<!-- page-banner section -->
<section class="page-banner-section">
	<div class="container">
		<h1>Categoria: <span><?php echo $nomeCategoria; ?></span></h1>
		<span><?php echo $totalPosts; ?> Posts encontrados</span>
	</div>
</section>
<!-- End page-banner section -->

<!-- blog section -->
<section class="blog-section">
	<div class="container">
		<div class="blog-box grid-style text-center">
			<div class="row">
				<?php
				$count = 0; // Inicializa o contador de colunas

				while ($row = mysqli_fetch_array($resultadoPosts)) {
					$id = $row['id'];
					$titulo = $row['titulo'];
					$imagem = $row['imagem'];
					$autor = $row['autor'];
					$conteudo = $row['conteudo'];
					$data_post = $row['data_post'];
					$slug = $row['slug'];

					// Verifica se é o início de uma nova linha
					if ($count % 3 == 0) {
						echo '<div class="row">'; // Abre uma nova linha a cada 3 colunas
					}
				?>

					<div class="col-lg-4 col-md-6">
						<div class="news-post article-post">
							<div class="image-holder">
								<?php $uploadsPath = realpath("../admin/uploads/"); ?>
								<img src="admin/<?php echo $imagem; ?>" alt="" style="width:100%;height:234px;object-fit: cover;">
							</div>
							<a class="text-link" href="#"><?php echo $nomeCategoria; ?></a>
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
								<li>by <a href="#"><?php echo $autor; ?></a></li>
							</ul>
							<p><?php echo substr($conteudo, 0, 100) . '...'; ?></p>
						</div>
					</div>

				<?php
					// Verifica se é o fim de uma linha
					if ($count % 3 == 2 || $count == mysqli_num_rows($resultadoPosts) - 1) {
						echo '</div>'; // Fecha a linha após a terceira coluna ou no último post
					}
					$count++; // Incrementa o contador de colunas
				}
				?>
			</div>

			<!-- Pagination -->
			<div class="pagination-box">
				<ul class="pagination-list">
					<?php
					if ($totalPaginas > 1) {
						if ($paginaAtual > 1) {
							$paginaAnterior = $paginaAtual - 1;
							echo "<li><a href='?nome=$nomeCategoria&pagina=$paginaAnterior'><i class='fa fa-angle-left'></i> Página Anterior</a></li>";
						}
						for ($i = 1; $i <= $totalPaginas; $i++) {
							if ($i == $paginaAtual) {
								echo "<li><a href='?nome=$nomeCategoria&pagina=$i' class='active'>$i</a></li>";
							} else {
								echo "<li><a href='?nome=$nomeCategoria&pagina=$i'>$i</a></li>";
							}
						}
						if ($paginaAtual < $totalPaginas) {
							$proximaPagina = $paginaAtual + 1;
							echo "<li><a href='?nome=$nomeCategoria&pagina=$proximaPagina'>Próxima Página <i class='fa fa-angle-right'></i></a></li>";
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