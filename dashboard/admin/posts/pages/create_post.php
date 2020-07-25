    <div class="container">
        <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Crear post</h1>
        <form style="margin-top: 30px;">
            <div class="form-row" style="margin-bottom: 20px;">
                <div class="col" style="margin-right: 10px;">
                    <div class="form-group"><label>Título:</label></div><input class="form-control" type="text" style="margin-top: -15px;"></div>
                <div class="col">
                    <div class="form-group"><label>Categoría:</label></div><select class="form-control" style="margin-top: -15px;"><option value="admin">Administrador</option><option value="publisher" selected="">Publicador</option></select></div>
            </div>
            <div class="form-row" style="margin-bottom: 20px;">
                <div class="col" style="margin-right: 10px;"><input type="file" multiple="" accept="image/*"></div>
            </div>
            <div class="form-row">
                <div class="col" style="margin-right: 10px;">
                    <div class="form-group"><label>Contenido:</label></div><textarea id="post_content" class="form-control" style="height: 300px;"></textarea></div>
                    <p class="small"><span id="chars_left">0</span>/1000</p>
            </div>
            <div class="form-row">
                <div class="col text-right" style="margin-top: 30px;"><button class="btn btn-danger" type="button" style="margin-right: 10px;">Cancelar</button><button class="btn btn-success" type="button">Crear</button>
                    <div class="btn-group" role="group"></div>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        var maxLength = 10;
        $('#post_content').keyup(function() {
            var textContent = $(this).val();
            var textLength = $(this).val().length;
            var leftChars = maxLength - textLength;
            $('#chars_left').text(leftChars);
            if (textLength == maxLength) {
                $(this).text('');
            }
        });
    </script>