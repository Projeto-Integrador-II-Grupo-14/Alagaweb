<?php if(isset($_GET['cadastro'])): ?>

    <script>
        Swal.fire({
            icon: 'success',
            title: 'Cadastro realizado!',
            text: 'Sua conta foi criada com sucesso.',
            confirmButtonColor: '#0d6efd'
        });
    </script>

<?php endif; ?>

<?php if(isset($_GET['login'])): ?>

    <script>
        Swal.fire({
            icon: 'success',
            title: 'Login realizado!',
            text: 'Você foi logado com sucesso.',
            confirmButtonColor: '#0d6efd'
        });
    </script>

<?php endif; ?>


<?php if(isset($_GET['erro'])): ?>

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'As senhas não coincidem.',
            confirmButtonColor: '#fd0d0d'
        });
    </script>

<?php endif; ?>


<?php if(isset($_GET['erro_login'])): ?>

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'E-mail ou senha inválidos.',
            confirmButtonColor: '#fd0d0d'
        });
    </script>

<?php endif; ?>
            

<?php if(isset($_GET['email_existe'])): ?>

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'O e-mail já está cadastrado.',
            confirmButtonColor: '#fd0d0d'
        });
    </script>

<?php endif; ?>


<?php if (isset($_GET['perfil']) && $_GET['perfil'] === 'sucesso'): ?>

<script>
    Swal.fire({
        icon: 'success',
        title: 'Perfil atualizado!',
        text: 'Suas informações foram salvas com sucesso.',
        confirmButtonText: 'OK',
        confirmButtonColor: '#0d6efd'
    });
</script>

<?php endif; ?>


<?php if (isset($_GET['erro']) && $_GET['erro'] === 'senha_curta'): ?>

<script>
    Swal.fire({
        icon: 'error',
        title: 'Senha muito curta',
        text: 'A nova senha deve possuir pelo menos 8 caracteres.',
        confirmButtonText: 'Entendi',
        confirmButtonColor: '#0d6efd'
    });
</script>

<?php endif; ?>


<?php if (isset($_GET['ocorrencia']) && $_GET['ocorrencia'] === 'sucesso'): ?>

<script>
    Swal.fire({
        icon: 'success',
        title: 'Ocorrência enviada!',
        text: 'Seu relatório foi registrado e está em análise.',
        confirmButtonText: 'OK',
        confirmButtonColor: '#0d6efd'
    });
</script>

<?php endif; ?>


<?php if (isset($_GET['erro']) && $_GET['erro'] === 'ocorrencia_campos'): ?>

<script>
    Swal.fire({
        icon: 'error',
        title: 'Campos obrigatórios',
        text: 'Preencha todos os campos da ocorrência.',
        confirmButtonText: 'Entendi',
        confirmButtonColor: '#0d6efd'
    });
</script>

<?php endif; ?>