<?php include 'layouts/header.php'; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <?php
                // Recebe a data de nascimento, verificando se ela existe
                $data_nascimento = $_POST['data_nascimento'] ?? null;

                if ($data_nascimento) {
                    // Carrega o arquivo XML com os dados dos signos
                    $signos = simplexml_load_file("signos.xml");

                    // Formata a data de nascimento para o formato MMDD para comparação numérica
                    $mes = date('m', strtotime($data_nascimento));
                    $dia = date('d', strtotime($data_nascimento));
                    $data_usuario = (int)($mes . $dia); 

                    $signo_encontrado = null;

                    // Percorre todos os signos no XML para encontrar o correspondente
                    foreach ($signos->signo as $signo) {
                        // Extrai dia e mês de início e fim do signo
                        list($dia_ini, $mes_ini) = explode('/', (string)$signo->dataInicio);
                        list($dia_fim, $mes_fim) = explode('/', (string)$signo->dataFim);
                        
                        // Converte para formato MMDD numérico
                        $inicio = (int)($mes_ini . $dia_ini);
                        $fim = (int)($mes_fim . $dia_fim);

                        // Trata o caso de Capricórnio (que cruza o final do ano)
                        if ($inicio > $fim) {
                            if ($data_usuario >= $inicio || $data_usuario <= $fim) {
                                $signo_encontrado = $signo;
                                break;
                            }
                        } else {
                            if ($data_usuario >= $inicio && $data_usuario <= $fim) {
                                $signo_encontrado = $signo;
                                break;
                            }
                        }
                    }

                    if ($signo_encontrado) {
                        $nome_signo = (string)$signo_encontrado->signoNome;
                        $descricao = (string)$signo_encontrado->descricao;

                        // --- MAPEAMENTO DE IMAGENS DE FUNDO (MARCA D'ÁGUA) ---
                        // Mapeia o nome do signo para o ficheiro SVG correspondente
                        $mapa_imagens = [
                            'Áries'       => 'aries_bg.svg',
                            'Touro'       => 'touro_bg.svg',
                            'Gêmeos'      => 'gemeos_bg.svg',
                            'Câncer'      => 'cancer_bg.svg',
                            'Leão'        => 'leao_bg.svg',
                            'Virgem'      => 'virgem_bg.svg',
                            'Libra'       => 'libra_bg.svg',
                            'Escorpião'   => 'escorpiao_bg.svg',
                            'Sagitário'   => 'sagitario_bg.svg',
                            'Capricórnio' => 'capricornio_bg.svg',
                            'Aquário'     => 'aquario_bg.svg',
                            'Peixes'      => 'peixes_bg.svg'
                        ];

                        // Define a imagem padrão caso não encontre no mapa (segurança)
                        $ficheiro_imagem = $mapa_imagens[$nome_signo] ?? 'galaxy.svg';
                        
                        // Caminho onde as imagens SVG estão guardadas (ajuste se necessário)
                        $caminho_imagem = 'assets/imgs/' . $ficheiro_imagem; 
                        ?>
                        
                        <div class="card shadow-lg custom-card text-center position-relative overflow-hidden">
                            <div class="sign-background-overlay" style="background-image: url('<?= $caminho_imagem ?>');"></div>
                            
                            <div class="position-relative z-1">
                                <h1 class="display-3 fw-bold mb-3" style="color: #e879f9;">✨ <?= $nome_signo ?></h1>
                                <p class="lead mb-4 text-light font-italic fs-4">"<?= $descricao ?>"</p>
                            </div>
                        </div>

                        <?php
                    } else {
                        echo "<div class='alert alert-danger shadow'>Signo não encontrado para a data informada.</div>";
                    }
                } else {
                    echo "<div class='alert alert-warning shadow'>Por favor, preencha a data de nascimento.</div>";
                }
                ?>
                
                <div class="mt-4 text-center">
                    <a href="index.php" class="btn btn-outline-light btn-lg">Fazer nova consulta</a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
