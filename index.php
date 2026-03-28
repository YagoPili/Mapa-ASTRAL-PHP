<?php include 'layouts/header.php'; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card shadow-lg custom-card text-center">
                    <h1 class="mb-3" style="color: #e879f9;">🔮 Mapa Astral</h1>
                    <p class="text-light mb-4">Descubra as características do seu signo zodiacal.</p>

                    <form action="show_zodiac_sign.php" method="POST">
                        <div class="mb-4 text-start">
                            <label for="data_nascimento" class="form-label fw-bold text-light">Insira a sua data de nascimento:</label>
                            <input type="date" class="form-control form-control-lg" name="data_nascimento" id="data_nascimento" required>
                        </div>
                        <button type="submit" class="btn custom-btn btn-lg w-100">Consultar Signo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
