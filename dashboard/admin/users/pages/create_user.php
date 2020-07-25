<script src="admin/users/js/create-user.js"></script>
<div class="container">
    <h1 class="text-left text-dark" style="margin-top: 20px;font-size: 24px;margin-bottom: 20px;color: black;">Crear usuario</h1>
    <form style="margin-top: 30px;">
        <div class="form-row" style="margin-bottom: 20px;">
            <div class="col" style="margin-right: 10px;">
                <div class="form-group">
                    <label>Nombre de usuario:</label>
                </div>
                <input id="username" class="form-control" type="text" style="margin-top: -15px;">
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Tipo de cuenta:</label>
                </div>
                <select id="account-type" class="form-control" style="margin-top: -15px;">
                    <option value="admin">Administrador</option>
                    <option value="publisher" selected="">Publicador</option>
                </select>
            </div>
        </div>
        <div class="form-row" style="margin-bottom: 20px;">
            <div class="col" style="margin-right: 10px;">
                <div class="form-group">
                    <label>Nombre:</label>
                </div>
                <input id="name" class="form-control" type="text" style="margin-top: -15px;">
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Apellidos:</label>
                </div>
                <input id="surname" class="form-control" type="text" style="margin-top: -15px;">
            </div>
        </div>
        <div class="form-row">
            <div class="col" style="margin-right: 10px;">
                <div class="form-group">
                    <label>Email:</label>
                </div>
                <input id="email1" class="form-control" type="email" style="margin-top: -15px;">
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Confirma email</label>
                </div>
                <input id="email2" class="form-control" type="email" style="margin-top: -15px;">
            </div>
        </div>
        <div class="form-row">
            <div class="col text-right" style="margin-top: 30px;">
                <button class="btn btn-danger" type="button" style="margin-right: 10px;" id="cancel">Cancelar</button>
                <button class="btn btn-success" type="button" id="submit" disabled>Crear</button>
                <div class="btn-group" role="group"></div>
            </div>
        </div>
    </form>
</div>