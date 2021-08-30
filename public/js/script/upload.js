let btnAdd = $('#btnAdd')
let inputFile = $('#inputFile')

// choose file
btnAdd.on('click', function() {
    inputFile.click()
})

inputFile.on('change', function() {
    let fileName = this.files[0].name;
    $('#fileName').val(fileName)
})
