<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blog');

class Usuario
{
    private $dbcon;

    public function __construct()
    {
        $this->dbcon = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        if ($this->dbcon->connect_error) {
            die("Failed to connect to MySQL: " . $this->dbcon->connect_error);
        }
    }

    public function insert($nome, $email, $data_cadastro, $senha)
    {
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $this->dbcon->prepare("INSERT INTO usuarios(nome, email, data_cadastro, senha) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $data_cadastro, $senhaCriptografada);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function fetchdata()
    {
        $result = $this->dbcon->query("SELECT * FROM usuarios");
        return $result;
    }

    public function fetchonerecord($userid)
    {
        $stmt = $this->dbcon->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    public function update($nome, $email, $data_cadastro, $senha, $userid)
    {
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $this->dbcon->prepare("UPDATE usuarios SET nome = ?, email = ?, data_cadastro = ?, senha = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nome, $email, $data_cadastro, $senhaCriptografada, $userid);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function delete($userid)
    {
        $stmt = $this->dbcon->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $userid);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function countUsers()
    {
        $result = $this->dbcon->query("SELECT COUNT(*) AS total FROM usuarios");
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}



class Categoria
{

    private $dbcon;

    public function __construct()
    {
        $this->dbcon = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        if ($this->dbcon->connect_error) {
            die("Failed to connect to MySQL: " . $this->dbcon->connect_error);
        }
    }

    public function insert($categoria)
    {
        $stmt = $this->dbcon->prepare("INSERT INTO categorias(categoria) VALUES(?)");
        $stmt->bind_param("s", $categoria);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function fetchdata()
    {
        $result = $this->dbcon->query("SELECT * FROM categorias");
        return $result;
    }

    public function fetchonerecord($categoriaid)
    {
        $stmt = $this->dbcon->prepare("SELECT * FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $categoriaid);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    public function update($categoria, $categoriaid)
    {
        $stmt = $this->dbcon->prepare("UPDATE categorias SET categoria = ? WHERE id = ?");
        $stmt->bind_param("si", $categoria, $categoriaid);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function delete($categoriaid)
    {
        $stmt = $this->dbcon->prepare("DELETE FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $categoriaid);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function countCategorias()
    {
        $result = $this->dbcon->query("SELECT COUNT(*) AS total FROM categorias");
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}


class Post
{
    private $dbcon;

    public function __construct()
    {
        $this->dbcon = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        if ($this->dbcon->connect_error) {
            die("Failed to connect to MySQL: " . $this->dbcon->connect_error);
        }
    }

    public function insert(...$params)
    {
        foreach ($params as &$param) {
            if (!mb_check_encoding($param, 'UTF-8')) {
                $param = mb_convert_encoding($param, 'UTF-8');
            }
        }

        $stmt = $this->dbcon->prepare("INSERT INTO posts (titulo, autor, categoria, data_post, imagem, conteudo, slug, destaque) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssi", ...$params);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function fetchdata()
    {
        $result = $this->dbcon->query("SELECT * FROM posts");
        return $result;
    }

    public function fetchonerecord($postid)
    {
        $stmt = $this->dbcon->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->bind_param("i", $postid);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    public function getCategoryName($categoriaid)
    {
        $stmt = $this->dbcon->prepare("SELECT categoria FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $categoriaid);
        $stmt->execute();
        $stmt->bind_result($categoria_nome);
        $stmt->fetch();
        $stmt->close();
        return $categoria_nome;
    }

    public function update($titulo, $autor, $categoria, $data_post, $imagem, $conteudo, $slug, $destaque, $postid)
    {
        // Obter a imagem atual do post antes de executar a atualização
        $stmt_get_image = $this->dbcon->prepare("SELECT imagem FROM posts WHERE id = ?");
        $stmt_get_image->bind_param("i", $postid);
        $stmt_get_image->execute();
        $stmt_get_image->bind_result($imagem_atual);
        $stmt_get_image->fetch();
        $stmt_get_image->close();

        // Verificar se uma nova imagem foi enviada
        if (empty($imagem)) {
            // Se não houver nova imagem, manter a imagem atual
            $imagem = $imagem_atual;
        } else {
            // Se houver uma nova imagem, remover a imagem atual do servidor
            if (!empty($imagem_atual) && file_exists($imagem_atual)) {
                unlink($imagem_atual); // Remover a imagem antiga do servidor
            }
        }

        // Preparar e executar a atualização do post
        $stmt = $this->dbcon->prepare("UPDATE posts SET titulo = ?, autor = ?, categoria = ?, data_post = ?, imagem = ?, conteudo = ?, slug = ?, destaque = ? WHERE id = ?");
        $stmt->bind_param("ssssssssi", $titulo, $autor, $categoria, $data_post, $imagem, $conteudo, $slug, $destaque, $postid);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }


    public function delete($postid)
    {
        $stmt = $this->dbcon->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $postid);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    public function countPosts()
    {
        $result = $this->dbcon->query("SELECT COUNT(*) AS total FROM posts");
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function generateSlug($str)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $str), '-'));
        return $slug;
    }

    public function getSlugFromID($postID)
    {
        $stmt = $this->dbcon->prepare("SELECT slug FROM posts WHERE id = ?");
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row['slug'];
    }
}



class CategoriasManager
{
    private $dbcon;

    public function __construct()
    {
        $this->dbcon = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        if ($this->dbcon->connect_error) {
            die("Failed to connect to MySQL: " . $this->dbcon->connect_error);
        }
    }

    public function fetchCategorias()
    {
        $query = "SELECT id, categoria FROM categorias";
        $result = $this->dbcon->query($query);

        if (!$result) {
            die("Error: " . $this->dbcon->error);
        }

        $categorias = $result->fetch_all(MYSQLI_ASSOC);

        return $categorias;
    }
}
