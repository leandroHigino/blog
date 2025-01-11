<?php
require_once "admin/functions/db_connect.php";
require_once "admin/functions/functions.php";

require "header.php";

// Número máximo de posts por página
$postsPorPagina = 6;

// Obtém o nome da categoria da URL
$nomeCategoria = $_GET['categoria'];

// Consulta para obter o ID da categoria
$sqlCategoria = "SELECT id FROM categorias WHERE categoria = ?";
$stmt = $mysqli->prepare($sqlCategoria);
$stmt->bind_param('s', $nomeCategoria);
$stmt->execute();
$resultadoCategoria = $stmt->get_result();
$rowCategoria = $resultadoCategoria->fetch_assoc();
$idCategoria = $rowCategoria['id'];

// Obtém o número da página atual
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Calcula o offset para a consulta SQL
$offset = ($paginaAtual - 1) * $postsPorPagina;

// Consulta para obter o total de posts da categoria
$sqlTotalPosts = "SELECT COUNT(*) AS total FROM posts WHERE categoria = ?";
$stmt = $mysqli->prepare($sqlTotalPosts);
$stmt->bind_param('i', $idCategoria);
$stmt->execute();
$resultadoTotalPosts = $stmt->get_result();
$rowTotalPosts = $resultadoTotalPosts->fetch_assoc();
$totalPosts = $rowTotalPosts['total'];

// Calcula o número total de páginas
$totalPaginas = ceil($totalPosts / $postsPorPagina);

// Consulta para obter os posts da categoria com limite e offset
$sqlPosts = "SELECT * FROM posts WHERE categoria = ? ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $mysqli->prepare($sqlPosts);
$stmt->bind_param('iii', $idCategoria, $postsPorPagina, $offset);
$stmt->execute();
$resultadoPosts = $stmt->get_result();
?>

<!-- page-banner section -->
<section class="page-banner-section">
	<div class="container">
		<h1>Categoria: <span><?php echo htmlspecialchars($nomeCategoria); ?></span></h1>
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
				// Inicializa o contador de posts
				$postCount = 0;

				while ($row = $resultadoPosts->fetch_assoc()) {
					$id        = $row['id'];
					$titulo    = $row['titulo'];
					$imagem    = $row['imagem'];
					$video     = $row['video']; // Adicionado para verificar o vídeo
					$autor     = $row['autor'];
					$conteudo  = $row['conteudo'];
					$data_post = $row['data_post'];
					$slug      = $row['slug'];

					// Se for o início de uma nova linha e não for a primeira coluna, fecha a linha anterior
					if ($postCount % 3 == 0 && $postCount != 0) {
						echo '</div><div class="row">';
					}
				?>
					<div class="col-lg-4 col-md-6">
						<div class="news-post article-post">
							<div class="image-holder">
								<?php if (!empty($video)) : ?>
									<!-- Exibe o vídeo se estiver disponível -->
									<video controls style="width:100%;height:250px;object-fit: cover;">
										<source src="admin/<?php echo htmlspecialchars($video); ?>" type="video/mp4">
										Seu navegador não suporta vídeos.
									</video>
								<?php elseif (!empty($imagem)) : ?>
									<!-- Exibe a imagem se estiver disponível -->
									<img src="admin/<?php echo htmlspecialchars($imagem); ?>" alt="" style="width:100%;height:250px;object-fit: cover;">
								<?php endif; ?>
							</div>
							<a class="text-link" href="#"><?php echo htmlspecialchars($nomeCategoria); ?></a>
							<h2><a href="post?slug=<?php echo htmlspecialchars($slug); ?>"><?php echo htmlspecialchars($titulo); ?></a></h2>
							<ul class="post-tags">
								<li>
									<?php
									$data_inicial = new DateTime($data_post);
									$data_atual = new DateTime();
									$intervalo = $data_inicial->diff($data_atual);
									echo $intervalo->format('Publicado há %a dias');
									?>
								</li>
								<li>by <a href="#"><?php echo htmlspecialchars($autor); ?></a></li>
							</ul>
							<p><?php echo nl2br(htmlspecialchars_decode(substr(strip_tags($conteudo), 0, 30))); ?></p>
						</div>
					</div>
				<?php
					$postCount++;
				}

				// Se houver posts, fecha a última linha aberta
				if ($postCount % 3 != 0) {
					echo '</div>';
				}
				?>
			</div>

			<!-- Pagination -->
			<div class="pagination-box text-center">
				<ul class="pagination-list">
					<?php
					if ($totalPaginas > 1) {
						if ($paginaAtual > 1) {
							$paginaAnterior = $paginaAtual - 1;
							echo "<li><a href='?categoria=" . urlencode($nomeCategoria) . "&pagina=$paginaAnterior'><i class='fa fa-angle-left'></i> Página Anterior</a></li>";
						}
						for ($i = 1; $i <= $totalPaginas; $i++) {
							if ($i == $paginaAtual) {
								echo "<li><a href='?categoria=" . urlencode($nomeCategoria) . "&pagina=$i' class='active'>$i</a></li>";
							} else {
								echo "<li><a href='?categoria=" . urlencode($nomeCategoria) . "&pagina=$i'>$i</a></li>";
							}
						}
						if ($paginaAtual < $totalPaginas) {
							$proximaPagina = $paginaAtual + 1;
							echo "<li><a href='?categoria=" . urlencode($nomeCategoria) . "&pagina=$proximaPagina'>Próxima Página <i class='fa fa-angle-right'></i></a></li>";
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