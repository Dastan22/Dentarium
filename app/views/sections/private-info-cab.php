<div id="cabPersonalInfo" class="container-fluid h-100 d-flex flex-column">
    <div class="row mb-auto input-container">
        <div class="col-12 d-flex personal-info-item p-3 mb-3">
            <p class="mb-0 mr-auto user-select-none">Имя</p>
            <input type="text" name="userName" class="text-right" data-field="name" data-original-value="<?= $this->data['user']['name'] ?? 'Данные не найдены' ?>" value="<?= $this->data['user']['name'] ?? 'Данные не найдены' ?>">
        </div>

        <div class="col-12 d-flex personal-info-item p-3 mb-3">
            <p class="mb-0 mr-auto user-select-none">Телефон</p>
            <input type="text" name="userPhone" class="text-right" data-field="phone" data-original-value="<?= $this->data['user']['phone'] ?? 'Данные не найдены' ?>" value="<?= $this->data['user']['phone'] ?? 'Данные не найдены' ?>">
        </div>

        <div class="col-12 d-flex personal-info-item p-3 mb-3">
            <p class="mb-0 mr-auto user-select-none">Адрес электронной почты</p>
            <input type="text" name="userEmail" class="text-right" data-field="email" data-original-value="<?= $this->data['user']['email'] ?? 'Данные не найдены' ?>" value="<?= $this->data['user']['email'] ?? 'Данные не найдены' ?>">
        </div>

        <div class="col-12 d-flex personal-info-item p-3">
            <p class="mb-0 mr-auto user-select-none">Адрес доставки</p>
            <input type="text" name="userAddress" class="text-right" data-field="address" data-original-value="<?= $this->data['user']['address'] ?? 'Данные не найдены' ?>" value="<?= $this->data['user']['address'] ?? 'Данные не найдены' ?>">
        </div>
    </div>

    <div class="row alert alert-danger" style="display: none"></div>
    <div class="row alert alert-success" style="display: none"></div>

    <div class="row d-flex align-items-center mt-3">
<!--        <div id="changePasswordButton" class="user-select-none cursor-pointer">Сменить пароль</div>-->
        <div id="exitFromAccountButton" class="col-auto ml-auto mb-3 mb-lg-0 py-3 px-5 user-select-none cursor-pointer">Выйти из аккаунта</div>
        <div class="w-100 d-block d-lg-none"></div>
        <div id="saveEditingButton" class="col-auto ml-auto ml-lg-4 py-3 px-5 user-select-none cursor-pointer not-allowed">Сохранить изменения</div>
    </div>
</div>