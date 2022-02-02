<div id="panelCategories" class="container-fluid h-100 d-flex flex-column">
    <div class="row mb-4">
        <div class="col p-0 user-select-none mr-5 d-flex align-items-center">
            <h4 class="mr-auto mb-0">Категории первого уровня</h4>
            <div class="icon add-btn cursor-pointer" data-level="first" style="width: 22px; height: 22px"></div>
        </div>
        <div class="col p-0 user-select-none mr-5 d-flex align-items-center">
            <h4 class="mr-auto mb-0">Категории второго уровня</h4>
            <div class="icon add-btn cursor-pointer" data-level="second" style="width: 22px; height: 22px"></div>
        </div>
        <div class="col p-0 user-select-none d-flex align-items-center">
            <h4 class="mr-auto mb-0">Категории третьего уровня</h4>
            <div class="icon add-btn cursor-pointer" data-level="third" style="width: 22px; height: 22px"></div>
        </div>
    </div>
    <div class="row">
        <div id="firstLevelCategories" class="col p-0 mr-5" data-current-category=""></div>
        <div id="secondLevelCategories" class="col p-0 mr-5" data-current-category=""></div>
        <div id="thirdLevelCategories" class="col p-0 "></div>
    </div>
</div>

<script src="/public/js/manageCategoriesPanel.js"></script>