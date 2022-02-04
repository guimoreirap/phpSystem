<?php
    require_once("verificaSessao.php");
?>
<?php
    require_once("conexao.php");
    require_once("funcoes.php");

    if (isset($_POST['salvar'])){

        //Upload do arquivo
        $imagem = "";
        if (!empty($_FILES['imagem']['name'])){
            $imagem = adicionaArquivo($_FILES['imagem']['name'], $_FILES['imagem']['tmp_name']);
        }

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $grupousuario_id = $_POST['grupousuario_id'];

        $sql = "insert into usuario (nome, email, senha, grupousuario_id, imagem) values ('{$nome}', '{$email}', '{$senha}', '{$grupousuario_id}', '{$imagem}')";

        mysqli_query($conexao, $sql);
        mysqli_close($conexao);

        $mensagem = "Registro inserido com sucesso";
    }
?>

    <?php
    $titulo = "Usuário Cadastrar";
    require_once ('cabecalho.php');
    ?>

    <?php
    $mensagem = "Cadastrar Usuário";
    require_once ('card.php');
    ?>

    <!-- FORMULARIO -->
    <form name="form" class="pt-3" method="post" enctype="multipart/form-data">
        <!-- NOME -->
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input name="nome" type="text" class="form-control" id="nome" aria-describedby="nome">
        </div>
        <!-- EMAIL -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input name="email" type="email" class="form-control" id="email" aria-describedby="email">
        </div>
        <!-- SENHA -->
        <div class="mb-3">
            <label for="senha" class="form-label">senha</label>
            <input name="senha" type="password" class="form-control" id="senha">
        </div>

        <!-- GRUPO DE USUARIO -->
        <div class="mb-3">
            <label for="grupousuario_id">Grupo de Usuario</label>
            <select name="grupousuario_id" id="grupousuario_id" class="form-select">
                <option value="">-- Selecione --</option>

                <?php
                    $sql = "select * from grupousuario order by nome";
                    $resultado = mysqli_query($conexao, $sql);

                    while ($linha = mysqli_fetch_array($resultado)):
                ?>

                <option value="<?= $linha['id'] ?>" > <?= $linha['nome'] ?> </option>
                <?php endwhile; ?>

            </select>
        </div>

        <!-- IMAGEM -->
        <div class="mb-3">
            <label for="imagem" class="form-label">Imagem</label>
            <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
        </div>

        <button name="salvar" type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>  Save
        </button>

        <a href="usuario-listar.php">
            <button type="button" class="btn btn-dark">
                <i class="fas fa-undo"></i> Voltar
            </button>
        </a>
    </form>

<?php mysqli_close($conexao); ?>
<?php require_once('rodape.php'); ?>