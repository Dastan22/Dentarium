$("#searchField").submit(searchProducts);

function searchProducts(e) {
    e.preventDefault();

    let searchString = $( this ).find('input[type="text"]').val();

    if(searchString.length === 0) {
        return;
    }

    location.assign('/index/?search=' + searchString + '#catalogBlock');
}