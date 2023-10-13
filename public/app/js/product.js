let productos = [];
let materiales = [];
let mano_obra = [];
let c_prod = 0;
let nombre = '';
let largo = '';
let ancho = '';
let espesor = '';
let filas = '';
let tubo = '';
let garantia = '';

function getTotalVenta() {

    let subtotal_venta = 0;
    let valor_venta = 0;
    let igv = 0;
    let total_venta = 0;
    let utilidad = document.getElementById('utilidad').value;
    let btnCreateDocument = document.getElementById('btn_create_document');

    if (utilidad == "") {
        document.getElementById('valor_venta').value = valor_venta;
        document.getElementById('igv').value = igv;
        document.getElementById('total_venta').value = total_venta;
        btnCreateDocument.disabled = true;
    }
    else {
        subtotal_venta = document.getElementById('subtotal').value;
        valor_venta = parseInt(subtotal_venta) + parseInt((subtotal_venta / 100) * utilidad);
        igv = Math.round((valor_venta / 100) * 18);
        total_venta = parseInt(igv + valor_venta);

        document.getElementById('valor_venta').value = valor_venta;
        document.getElementById('igv').value = igv;
        document.getElementById('total_venta').value = total_venta;
        
        if (total_venta != '') {
            btnCreateDocument.disabled = false;
        }
        else {
            btnCreateDocument.disabled = true;
        }
    }
}

function add_product_document() {
    let dataSend = {};
    let sum_m = 0;
    let sum_l = 0;
    let unit_value = 0;
    let sumatoria_total = 0;
    let contador_m = 0;
    let contador_l = 0;    

    let tableBodyD = document.getElementById('list-products');
    let table_materials = document.getElementById('list-materials');
    let table_labours = document.getElementById('list-mano-obra');
    let rows_materials = table_materials.rows.length;
    let rows_labours = table_labours.rows.length;
    let precio_costo = document.getElementsByClassName('valor');    
    let btn_p = document.getElementById('btn-create-product');

    if (rows_materials == 2 && rows_labours == 10) {
        for (let i = 0; i < precio_costo.length; i++) {
            if (precio_costo[i].value == "") {
                precio_costo[i].classList.add('border', 'border-danger');
            }
        }

        document.querySelectorAll('#list-materials tr').forEach(function (e) {
            let cost_m = 0;
            cost_m = e.querySelector('.costo_total').value;
            if (cost_m == "") {
                contador_m++;
                e.querySelector('.costo_total').classList.add('border', 'border-danger');
            }
            else {
                e.querySelector('.costo_total').classList.remove('border', 'border-danger');
                sum_m += parseInt(cost_m.replace('$', ''));
            }

        });
        document.querySelectorAll('#list-mano-obra tr').forEach(function (e) {
            let cost_l = 0;
            cost_l = e.querySelector('.costo_total_lb').value;
            if (cost_l == "") {
                contador_l++;
                e.querySelector('.costo_total_lb').classList.add('border', 'border-danger');
            }
            else {
                e.querySelector('.costo_total_lb').classList.remove('border', 'border-danger');
                sum_l += parseInt(cost_l.replace('$', ''));
            }

        });

        unit_value = sum_m + sum_l;

        dataSend.name = document.getElementById('name').value;
        dataSend.quantity = document.getElementById('quantity').value;
        dataSend.unit_value = unit_value;
        dataSend.long = document.getElementById('long').value;
        dataSend.width = document.getElementById('width').value;
        dataSend.thickness = document.getElementById('thickness').value;
        dataSend.rows = document.getElementById('rows').value;
        dataSend.tube = document.getElementById('tube').value;        
        dataSend.warranty = document.getElementById('warranty').value;

        console.log(contador_m)
        console.log(contador_l)

        if (contador_m == 0 && contador_l == 0) {
            c_prod++;            

            $.ajax({
                method: 'POST',
                data: dataSend ,
                url: '/products',
                beforeSend: function(){   
                    btn_p.disabled = true;  
                },
                statusCode: {
                    422: function (response) {
                        c_prod--;
                        document.getElementById('alert-validacion').classList.remove('d-none');
                        let validacion = [
                            'name','long','width','thickness','rows','tube','quantity','warranty'
                        ];

                        let errors = response.responseJSON.errors;
                        validacion.forEach(function(valor){
                            document.getElementById(valor+'-error').innerText = '';
                            if(errors[valor]){
                                let mensajes = errors[valor];
                                for(let i = 0; i < mensajes.length; i++){
                                    let div = document.createElement('div');
                                    let mensaje = document.getElementById(valor+'-error').appendChild(div);
                                    mensaje.innerText = mensajes[i];    
                                    mensaje.className += 'mt-1';
                                    document.getElementById(valor+'-error').style.color = 'red'; 
                                    document.getElementById(valor).className += ' is-invalid';
                                }
                            }
                            else{
                                document.getElementById(valor+'-error').innerText = '';
                                document.getElementById(valor).classList.remove('is-invalid');
                            }   

                        });
                        $('html, body #documento-modal').animate({scrollTop:0}, 'slow');
                        btn_p.disabled = false;  

                    },       
                    200: function (response) {
                        console.log(response['success']);
                        document.getElementById('alert-validacion').classList.add('d-none');
                        let object_producto = {
                            c_prod: c_prod,
                            name: nombre,
                            long : largo,
                            width : ancho,
                            thickness : espesor,
                            rows : filas,
                            tube : tubo,
                            warranty : garantia,
                        };
            
                        productos.push(object_producto);
                        console.log(productos);
            
                        document.querySelectorAll('#list-materials tr').forEach(function (e) {
                            let cost_m = e.querySelector('.costo_total').value;
                            let object_material = {
                                c_prod: c_prod,
                                material_id: e.querySelector('.material_id').value,
                                quantity: e.querySelector('.quantity').value,
                                parts: e.querySelector('.parts').value,
                                inches: e.querySelector('.inches').value,
                                total_material: e.querySelector('.total_material').value,
                                costo_total: cost_m.replace('$', '')
                            };
                            materiales.push(object_material);
                        });
            
                        console.log(materiales);
            
                        document.querySelectorAll('#list-mano-obra tr').forEach(function (e) {
                            let cost_l = e.querySelector('.costo_total_lb').value;
                            let object_labour = {
                                c_prod: c_prod,
                                labour_id: e.querySelector('.labour_id').value,
                                description: e.querySelector('.description').value,
                                service_charge: e.querySelector('.service_charge').value,
                                costo_total_lb: cost_l.replace('$', '')
                            };
                            mano_obra.push(object_labour);
                        });
            
                        console.log(mano_obra);                    

                        $('#nodata').remove();
                        let newRow = tableBodyD.insertRow(-1);
                        let count = tableBodyD.rows.length;
                        newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" value="'+c_prod+'"><td class="fw-bold">' + response['success'][0] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold cantidad" id="" name="" readonly placeholder="Ingresar cantidad" value=' + response['success'][1] + '></td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold v_unitario" name="" readonly value=' + response['success'][2] + '></td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold total" id="" name="" readonly placeholder="$0.00" value=' + response['success'][3] + '></td><td><button class="btn btn-danger" onclick="delete_row_product(this)"><i class="fas fa-trash-alt"></i></button></td>';

                        let total = document.getElementsByClassName('total');
                        for (let i = 0; i < total.length; i++) {
                            let total_p = total[i].value;
                            sumatoria_total += parseInt(total_p.replace('$', ''));
                        }
                        document.getElementById('subtotal').value = sumatoria_total;                                       
                        btn_p.disabled = false;    
                        
                        Swal.fire({
                            title: '¿Desea continuar?',
                            text: "Se cotizará un nuevo producto",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'si, continuar',
                            cancelButtonText: 'No',
                            customClass: 'swal-height',
                            allowOutsideClick: false,
                        }).then((result) => {                
                            if(result.isConfirmed) {                                
                                removeData();
                            }
                            else{
                                removeData();
                                document.getElementById('alert-validacion').classList.add('d-none');
                                $('#documento-modal').modal('hide');      

                            }              
            
                        })
                    },
                    500: function () {
                        console.log('error');
                    }
                }
            });            

        }

    }
    else {
        alert('Favor de valorizar los materiales y/o mano de obra del producto');
    }
}

function add_material_product() {
    let dataSend = {};
    let data = [];

    let select = document.getElementById('material');
    let tableBody = document.getElementById('list-materials');

    nombre = document.getElementById('name').value;
    largo = document.getElementById('long').value;
    ancho = document.getElementById('width').value;
    espesor = document.getElementById('thickness').value;
    filas = document.getElementById('rows').value;
    tubo = document.getElementById('tube').value;
    garantia = document.getElementById('warranty').value;
    let quantity = document.getElementById('quantity').value;
    let btn_m = document.getElementById('pills-home-tab');

    dataSend.id = document.getElementById('material').value;
    dataSend.name = nombre;
    dataSend.long = largo;
    dataSend.width = ancho;
    dataSend.thickness = espesor;
    dataSend.rows = filas;
    dataSend.tube = tubo;

    if (dataSend.name != "" && dataSend.long != "" && dataSend.width != "" && dataSend.thickness != "" && dataSend.rows != "" && dataSend.tube != 'Seleccionar...' && quantity != "" && garantia != "") {
        if (tableBody.rows.length >= 2) {
            alert('Recordar: La lista de materiales ya esta realizada');
        }
        else {
            for (let i = 0; i < select.length; i++) {
                let object = {};
                object.id = select[i].value;
                object.des = select[i].innerHTML;
                data.push(object);
            }
            let objetos = JSON.stringify(data);
            //console.log(data);
            $.ajax({
                method: 'POST',
                data: { dataSend: dataSend, objetos: objetos },
                url: '/material',
                beforeSend: function(){   
                    btn_m.disabled = true;  
                    document.getElementById('PageLoadProgress').style.display = "block";        
                },
                statusCode: {
                    422: function (response) {
                        console.log(response);
                    },
                    200: function (response) {
                        console.log(response['success']);
                        document.getElementById('PageLoadProgress').style.display = "none"; 
                        if (response['success']['tubos'][0] == 1) {
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="material_id" name="material_id" value="' + response['success']['tubos'][0] + '"><td class="fw-bold">' + response['success']['tubos'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold quantity" id="cantidadTubos" name="cantidad" readonly value=' + response['success']['tubos'][2] + '> tubos</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold parts" name="piezas" readonly value=' + response['success']['tubos'][3] + '> x rollo</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold inches" name="pulgadas" readonly value=' + response['success']['tubos'][4] + '> tuberia</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold total_material" name="total-material" readonly value=' + response['success']['tubos'][5] + '> rollos</td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold valor sale_price" name="precio" placeholder="Ingresar precio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold costo_total" id="total_cost_tube" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_material(this)"><i class="fas fa-check text-white"></i></button></td>';
                        }
                        if (response['success']['laminas'][0] == 2) {
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="material_id" name="material_id" value="' + response['success']['laminas'][0] + '"><td class="fw-bold">' + response['success']['laminas'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold quantity" id="cantidadLaminas" name="cantidad" readonly value=' + response['success']['laminas'][2] + '> láminas</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold parts" name="piezas" readonly value=' + response['success']['laminas'][3] + '> x plancha</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold inches" name="pulgadas" readonly value=' + response['success']['laminas'][4] + '> láminas</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold total_material" name="total-material" readonly value=' + response['success']['laminas'][5] + '> metros</td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold valor sale_price" name="precio" placeholder="Ingresar precio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold costo_total" id="total_cost_lamina" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_material(this)"><i class="fas fa-check text-white"></i></button></td>';
                        }
                        btn_m.disabled = false;
                    },
                    500: function () {
                        console.log('error');
                    }
                }
            });
        }
    }
    else {
        alert('Ingrese las medidas del producto');
    }
}

/*function add_material_product() {

    let dataSend = {};

    let select = document.getElementById('material');
    let selectMaterial = select.value;
    let selectDesc = select.options[select.selectedIndex].innerHTML;
    let tableBody = document.getElementById('list-materials');
    let rows = tableBody.getElementsByTagName('tr');

    dataSend.id = document.getElementById('material').value;
    dataSend.name = document.getElementById('name').value;
    dataSend.long = document.getElementById('long').value;
    dataSend.width = document.getElementById('width').value;
    dataSend.thickness = document.getElementById('thickness').value;
    dataSend.rows = document.getElementById('rows').value;
    dataSend.tube = document.getElementById('tube').value;
    dataSend.material = selectDesc;

    if (dataSend.name != "" && dataSend.long != "" && dataSend.width != "" && dataSend.thickness != "" && dataSend.rows != "") {
        if (tableBody.rows.length == 2) {
            alert("No se puede agregar mas elementos");
        }
        else {
            for (let i = 0; i < rows.length; i++) {
                let item = rows[i].getElementsByTagName('td')[0];
                if (item.innerHTML == selectDesc) {
                    $("#material").val('Seleccionar...');
                    return false;
                }
            }
            if (selectMaterial == 1) {
                $.ajax({
                    method: 'GET',
                    data: dataSend,
                    url: '/productos/material',
                    statusCode: {
                        422: function (response) {
                            console.log(response);
                        },
                        200: function (response) {
                            console.log(response['success']);
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="material_id" name="material_id" value="' + response['success'][0] + '"><td class="fw-bold">' + response['success'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold quantity" id="cantidadTubos" name="cantidad" readonly value=' + response['success'][2] + '> tubos</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold parts" name="piezas" readonly value=' + response['success'][3] + '> x rollo</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold inches" name="pulgadas" readonly value=' + response['success'][4] + '> tuberia</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold total_material" name="total-material" readonly value=' + response['success'][5] + '> rollos</td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold sale_price" name="precio" placeholder="Ingresar precio"></td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold" id="total_cost_tube" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_material(this)"><i class="fas fa-check text-white"></i></button></td><td><button class="btn btn-danger" onclick="delete_row_material(this)"><i class="fas fa-trash-alt"></i></button></td>';
                        },
                        500: function () {
                            console.log('error');
                        }
                    }
                });
            }
            if (selectMaterial == 2) {
                $.ajax({
                    method: 'GET',
                    data: dataSend,
                    url: '/productos/material',
                    statusCode: {
                        422: function (response) {
                            console.log(response);
                        },
                        200: function (response) {
                            console.log(response['success']);
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="material_id" name="material_id" value="' + response['success'][0] + '"><td class="fw-bold">' + response['success'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold quantity" id="cantidadLaminas" name="cantidad" readonly value=' + response['success'][2] + '> láminas</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold parts" name="piezas" readonly value=' + response['success'][3] + '> x plancha</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold inches" name="pulgadas" readonly value=' + response['success'][4] + '> láminas</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold total_material" name="total-material" readonly value=' + response['success'][5] + '> metros</td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold sale_price" name="precio" placeholder="Ingresar precio"></td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold" id="total_cost_lamina" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_material(this)"><i class="fas fa-check text-white"></i></button></td><td><button class="btn btn-danger" onclick="delete_row_material(this)"><i class="fas fa-trash-alt"></i></button></td>';
                        },
                        500: function () {
                            console.log('error');
                        }
                    }
                });


            }
        }

        $("#material").val('Seleccionar...');
    }
    else {
        alert('Ingrese los datos requeridos');
        $("#material").val('Seleccionar...');
    }

}
*/

function validarInputsMaterials(index) {
    let row = index.parentNode.parentNode;
    let data = row.getElementsByTagName('input')[5].value;

    if (data == "" || data == 0) {
        row.getElementsByTagName('input')[5].classList.add('border', 'border-danger');
        row.getElementsByTagName('input')[6].classList.add('border', 'border-danger');
    }
    else {
        row.getElementsByTagName('input')[5].classList.remove('border', 'border-danger');
        row.getElementsByTagName('input')[6].classList.remove('border', 'border-danger');
    }
}

function validarInputsLabour(index) {
    let row = index.parentNode.parentNode;
    let data = row.getElementsByTagName('input')[2].value;

    if (data == "" || data == 0) {
        row.getElementsByTagName('input')[2].classList.add('border', 'border-danger');
        row.getElementsByTagName('input')[3].classList.add('border', 'border-danger');
    }
    else {
        row.getElementsByTagName('input')[2].classList.remove('border', 'border-danger');
        row.getElementsByTagName('input')[3].classList.remove('border', 'border-danger');
    }
}


$(".formModal").submit(function (e) {
    e.preventDefault();
})

$(".formModal").submit(function (e) {
    e.preventDefault();
})

function cost_material(index) {
    let row = index.parentNode.parentNode;
    let precio = row.getElementsByTagName('input')[5].value;
    let total_material = row.getElementsByTagName('input')[4].value;
    let costo_total;
    costo_total = total_material * precio;
    validarInputsMaterials(index);
    if (costo_total == "") {
        row.getElementsByTagName('input')[6].value = '$0.00';
    }
    else {
        row.getElementsByTagName('input')[6].value = '$' + costo_total;
    }
}

/*function delete_row_material(e) {

    document.getElementById("formContent").addEventListener('submit', (e) => {
        e.preventDefault();
    });

    let tableBody = document.getElementById('list-materials');
    let row = e.parentNode.parentNode;
    tableBody.removeChild(row);

    let rows = tableBody.getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        let row = rows[i];
        let items = row.getElementsByTagName('th')[0];
        items.innerHTML = i + 1;
    }
}*/

function delete_row_product(e) {

    document.getElementById("formContent").addEventListener('submit', (e) => {
        e.preventDefault();
    });

    let tableBody = document.getElementById('list-products');
    let row = e.parentNode.parentNode;
    tableBody.removeChild(row);

    let rows = tableBody.getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        let row = rows[i];
        let items = row.getElementsByTagName('th')[0];
        items.innerHTML = i + 1;
    }

    productos.forEach((item) => {
        for(let index in materiales){
            if(materiales[index].c_prod == item.c_prod){                
                materiales.splice(index, 2);
            }
            for(let index in mano_obra){
                if(mano_obra[index].c_prod == item.c_prod){                
                    mano_obra.splice(index, 10);
                }
            }
            productos.splice(index, 1);
        }
        
    });
    console.log(productos);
    console.log(materiales);
    console.log(mano_obra);

    /*let index_p = productos.findIndex(el => el.c_prod == row.getElementsByTagName('input')[0].value);  
    productos.splice(index_p, 1);      
    let index_m = materiales.findIndex(el => el.c_prod == row.getElementsByTagName('input')[0].value);  
    materiales.splice(index_m, 2); 
    let index_l = mano_obra.findIndex(el => el.c_prod == row.getElementsByTagName('input')[0].value);  
    mano_obra.splice(index_l, 10);*/ 
               
    /*console.log('c_prod eliminado: ' + row.getElementsByTagName('input')[0].value);
    console.log('indice_p eliminado: ' + index_p);
    console.log(productos);*/    

    /*console.log('c_prod eliminado: ' + row.getElementsByTagName('input')[0].value);
    console.log('indice_m eliminado: ' + index_m);
    console.log(materiales);*/    

    /*console.log('c_prod eliminado: ' + row.getElementsByTagName('input')[0].value);
    console.log('indice_m eliminado: ' + index_l);
    console.log(mano_obra);*/

    let row_p = e.parentNode.parentNode;
    let data = row_p.getElementsByTagName('input')[3].value;
    document.getElementById('subtotal').value -= parseInt(data.replace('$', ''));
    document.getElementById('utilidad').value = '';
    document.getElementById('valor_venta').value = '';
    document.getElementById('igv').value = '';
    document.getElementById('total_venta').value = '';
    if (tableBody.rows.length == 0) {
        $('#list-products').append('<tr id="nodata"><td colspan="12">No hay datos ingresados...</td></tr>');
    }
    else {
        $('#nodata').remove();
    }
}

function add_labour_product() {

    let dataSend = {};
    let data = [];
    let select = document.getElementById('servicios');
    let tableBody = document.getElementById('list-mano-obra');
    let laminas = document.getElementById('cantidadLaminas').value;
    let tubos = document.getElementById('cantidadTubos').value;
    let quantity = document.getElementById('quantity').value;
    let btn_l = document.getElementById('pills-profile-tab');

    nombre = document.getElementById('name').value;
    largo = document.getElementById('long').value;
    ancho = document.getElementById('width').value;
    espesor = document.getElementById('thickness').value;
    filas = document.getElementById('rows').value;
    tubo = document.getElementById('tube').value;
    garantia = document.getElementById('warranty').value;

    dataSend.id = document.getElementById('servicios').value;
    dataSend.name = nombre;
    dataSend.long = largo;
    dataSend.width = ancho;
    dataSend.thickness = espesor;
    dataSend.rows = filas;
    dataSend.tube = tubo;
    dataSend.laminas = laminas;
    dataSend.tubos = tubos;

    if (dataSend.name != "" && dataSend.long != "" && dataSend.width != "" && dataSend.thickness != "" && dataSend.rows != "" && dataSend.tube != 'Seleccionar...' && garantia != "" && quantity != "") {
        if (tableBody.rows.length >= 10) {
            alert('Recordar: La lista de mano de obra ya esta realizada');
        }
        else {
            for (let i = 0; i < select.length; i++) {
                let object = {};
                object.id = select[i].value;
                object.des = select[i].innerHTML;
                data.push(object);
            }
            let objetos = JSON.stringify(data);
            //console.log(data);
            $.ajax({
                method: 'POST',
                data: { dataSend: dataSend, objetos: objetos },
                url: '/labour',
                beforeSend: function(){   
                    btn_l.disabled = true;  
                    document.getElementById('PageLoadProgress').style.display = "block";        
                },
                statusCode: {
                    422: function (response) {
                        console.log(response);
                    },                    
                    200: function (response) {
                        console.log(response['success']);
                        document.getElementById('PageLoadProgress').style.display = "none";  
                        if (response['success']['corte'][0] == 1) {
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success']['corte'][0] + '"><td class="fw-bold">' + response['success']['corte'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value="' + response['success']['corte'][2] + '"></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold valor service_charge" name="service-charge" placeholder="Ingresar cobro servicio">centimos</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold costo_total_lb" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td>';
                        }
                        if (response['success']['troquelado'][0] == 2) {
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success']['troquelado'][0] + '"><td class="fw-bold">' + response['success']['troquelado'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value="' + response['success']['troquelado'][2] + '"></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold valor service_charge" name="service-charge" placeholder="Ingresar cobro servicio">centimos</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold costo_total_lb" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td>';
                        }
                        if (response['success']['llenado'][0] == 3) {
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success']['llenado'][0] + '"><td class="fw-bold">' + response['success']['llenado'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value="' + response['success']['llenado'][2] + '"></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold valor service_charge" name="service-charge" placeholder="Ingresar cobro servicio">soles</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold costo_total_lb" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td>';
                        }
                        if (response['success']['parrillas'][0] == 4) {
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success']['parrillas'][0] + '"><td class="fw-bold">' + response['success']['parrillas'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value=' + response['success']['parrillas'][2] + '></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold valor service_charge" name="service-charge" placeholder="Ingresar cobro servicio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold costo_total_lb" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td>';
                        }
                        if (response['success']['codos'][0] == 5) {
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success']['codos'][0] + '"><td class="fw-bold">' + response['success']['codos'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value="' + response['success']['codos'][2] + '"></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold valor service_charge" name="service-charge" placeholder="Ingresar cobro servicio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold costo_total_lb" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td>';
                        }
                        if (response['success']['oxigas'][0] == 6) {
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success']['oxigas'][0] + '"><td class="fw-bold">' + response['success']['oxigas'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value="' + response['success']['oxigas'][2] + '"></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold valor service_charge" name="service-charge" placeholder="Ingresar cobro servicio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold costo_total_lb" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td>';
                        }
                        if (response['success']['soldadura'][0] == 7) {
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success']['soldadura'][0] + '"><td class="fw-bold">' + response['success']['soldadura'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value="' + response['success']['soldadura'][2] + '"></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold valor service_charge" name="service-charge" placeholder="Ingresar cobro servicio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold costo_total_lb" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td>';
                        }
                        if (response['success']['obra'][0] == 8) {
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success']['obra'][0] + '"><td class="fw-bold">' + response['success']['obra'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value=' + response['success']['obra'][2] + '></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold valor service_charge" name="service-charge" placeholder="Ingresar cobro servicio">soles</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold costo_total_lb" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td>';
                        }
                        if (response['success']['pruebas'][0] == 9) {
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success']['pruebas'][0] + '"><td class="fw-bold">' + response['success']['pruebas'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value="' + response['success']['pruebas'][2] + '"></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold valor service_charge" name="service-charge" placeholder="Ingresar cobro servicio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold costo_total_lb" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td>';
                        }
                        if (response['success']['acabados'][0] == 10) {
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success']['acabados'][0] + '"><td class="fw-bold">' + response['success']['acabados'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value="' + response['success']['acabados'][2] + '"></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold valor service_charge" name="service-charge" placeholder="Ingresar cobro servicio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold costo_total_lb" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td>';
                        }
                        btn_l.disabled = false;
                    },
                    500: function () {
                        console.log('error');
                    }
                }
            });
        }
    }
    else {
        alert('Ingrese las medidas del producto');
    }

}


/*function add_labour_product() {

    let dataSend = {};

    let select = document.getElementById('servicios');
    let selectLabour = select.value;
    let selectDesc = select.options[select.selectedIndex].innerHTML;
    let tableBody = document.getElementById('list-mano-obra');
    let rows = tableBody.getElementsByTagName('tr');
    let laminas = document.getElementById('cantidadLaminas').value;
    let tubos = document.getElementById('cantidadTubos').value;

    dataSend.id = document.getElementById('servicios').value;
    dataSend.name = document.getElementById('name').value;
    dataSend.long = document.getElementById('long').value;
    dataSend.width = document.getElementById('width').value;
    dataSend.thickness = document.getElementById('thickness').value;
    dataSend.rows = document.getElementById('rows').value;
    dataSend.tube = document.getElementById('tube').value;
    dataSend.laminas = laminas;
    dataSend.tubos = tubos;
    dataSend.servicioDesc = selectDesc;

    if (dataSend.name != "" && dataSend.long != "" && dataSend.width != "" && dataSend.thickness != "" && dataSend.rows != "" && laminas != "") {
        if (tableBody.rows.length == 10) {
            alert("No se puede agregar mas elementos");
        }
        else {
            for (let i = 0; i < rows.length; i++) {
                let item = rows[i].getElementsByTagName('td')[0];
                if (item.innerHTML == selectDesc) {
                    $("#servicios").val('Seleccionar...');
                    return false;
                }
            }
            if (selectLabour == 1) {
                $.ajax({
                    method: 'POST',
                    data: dataSend,
                    url: '/productos/labour',
                    statusCode: {
                        422: function (response) {
                            console.log(response);
                        },
                        200: function (response) {
                            console.log(response['success']);
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success'][0] + '"><td class="fw-bold">' + response['success'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value=' + response['success'][2] + '> láminas de aluminio</td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold service-charge" name="service-charge" placeholder="Ingresar cobro servicio">centimos</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td><td><button class="btn btn-danger" onclick="delete_row_mano_obra(this)"><i class="fas fa-trash-alt"></i></button></td>';
                        },
                        500: function () {
                            console.log('error');
                        }
                    }
                });
            }
            if (selectLabour == 2) {
                $.ajax({
                    method: 'POST',
                    data: dataSend,
                    url: '/productos/labour',
                    statusCode: {
                        422: function (response) {
                            console.log(response);
                        },
                        200: function (response) {
                            console.log(response['success']);
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success'][0] + '"><td class="fw-bold">' + response['success'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value=' + response['success'][2] + '> láminas de aluminio</td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold service-charge" name="service-charge" placeholder="Ingresar cobro servicio">centimos</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td><td><button class="btn btn-danger" onclick="delete_row_mano_obra(this)"><i class="fas fa-trash-alt"></i></button></td>';
                        },
                        500: function () {
                            console.log('error');
                        }
                    }
                });
            }
            if (selectLabour == 3) {
                $.ajax({
                    method: 'POST',
                    data: dataSend,
                    url: '/productos/labour',
                    statusCode: {
                        422: function (response) {
                            console.log(response);
                        },
                        200: function (response) {
                            console.log(response['success']);
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success'][0] + '"><td class="fw-bold">' + response['success'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value=' + response['success'][2] + '></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold service-charge" name="service-charge" placeholder="Ingresar cobro servicio">soles</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td><td><button class="btn btn-danger" onclick="delete_row_mano_obra(this)"><i class="fas fa-trash-alt"></i></button></td>';
                        },
                        500: function () {
                            console.log('error');
                        }
                    }
                });
            }
            if (selectLabour == 4) {
                $.ajax({
                    method: 'POST',
                    data: dataSend,
                    url: '/productos/labour',
                    statusCode: {
                        422: function (response) {
                            console.log(response);
                        },
                        200: function (response) {
                            console.log(response['success']);
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success'][0] + '"><td class="fw-bold">' + response['success'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value=' + response['success'][2] + '></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold service-charge" name="service-charge" placeholder="Ingresar cobro servicio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td><td><button class="btn btn-danger" onclick="delete_row_mano_obra(this)"><i class="fas fa-trash-alt"></i></button></td>';
                        },
                        500: function () {
                            console.log('error');
                        }
                    }
                });
            }
            if (selectLabour == 5) {
                $.ajax({
                    method: 'POST',
                    data: dataSend,
                    url: '/productos/labour',
                    statusCode: {
                        422: function (response) {
                            console.log(response);
                        },
                        200: function (response) {
                            console.log(response['success']);
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success'][0] + '"><td class="fw-bold">' + response['success'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value=' + response['success'][2] + '>codos en panel superior/inferior</td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold service-charge" name="service-charge" placeholder="Ingresar cobro servicio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td><td><button class="btn btn-danger" onclick="delete_row_mano_obra(this)"><i class="fas fa-trash-alt"></i></button></td>';
                        },
                        500: function () {
                            console.log('error');
                        }
                    }
                });
            }
            if (selectLabour == 6) {
                $.ajax({
                    method: 'POST',
                    data: dataSend,
                    url: '/productos/labour',
                    statusCode: {
                        422: function (response) {
                            console.log(response);
                        },
                        200: function (response) {
                            console.log(response['success']);
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success'][0] + '"><td class="fw-bold">' + response['success'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value=' + response['success'][2] + '></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold service-charge" name="service-charge" placeholder="Ingresar cobro servicio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td><td><button class="btn btn-danger" onclick="delete_row_mano_obra(this)"><i class="fas fa-trash-alt"></i></button></td>';
                        },
                        500: function () {
                            console.log('error');
                        }
                    }
                });
            }
            if (selectLabour == 7) {
                $.ajax({
                    method: 'POST',
                    data: dataSend,
                    url: '/productos/labour',
                    statusCode: {
                        422: function (response) {
                            console.log(response);
                        },
                        200: function (response) {
                            console.log(response['success']);
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success'][0] + '"><td class="fw-bold">' + response['success'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value=' + response['success'][2] + '></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold service-charge" name="service-charge" placeholder="Ingresar cobro servicio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td><td><button class="btn btn-danger" onclick="delete_row_mano_obra(this)"><i class="fas fa-trash-alt"></i></button></td>';
                        },
                        500: function () {
                            console.log('error');
                        }
                    }
                });
            }
            if (selectLabour == 8) {
                $.ajax({
                    method: 'POST',
                    data: dataSend,
                    url: '/productos/labour',
                    statusCode: {
                        422: function (response) {
                            console.log(response);
                        },
                        200: function (response) {
                            console.log(response['success']);
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success'][0] + '"><td class="fw-bold">' + response['success'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value=' + response['success'][2] + '></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold service-charge" name="service-charge" placeholder="Ingresar cobro servicio">soles</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td><td><button class="btn btn-danger" onclick="delete_row_mano_obra(this)"><i class="fas fa-trash-alt"></i></button></td>';
                        },
                        500: function () {
                            console.log('error');
                        }
                    }
                });
            }
            if (selectLabour == 9) {
                $.ajax({
                    method: 'POST',
                    data: dataSend,
                    url: '/productos/labour',
                    statusCode: {
                        422: function (response) {
                            console.log(response);
                        },
                        200: function (response) {
                            console.log(response['success']);
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success'][0] + '"><td class="fw-bold">' + response['success'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value=' + response['success'][2] + '></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold service-charge" name="service-charge" placeholder="Ingresar cobro servicio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td><td><button class="btn btn-danger" onclick="delete_row_mano_obra(this)"><i class="fas fa-trash-alt"></i></button></td>';
                        },
                        500: function () {
                            console.log('error');
                        }
                    }
                });
            }
            if (selectLabour == 10) {
                $.ajax({
                    method: 'POST',
                    data: dataSend,
                    url: '/productos/labour',
                    statusCode: {
                        422: function (response) {
                            console.log(response);
                        },
                        200: function (response) {
                            console.log(response['success']);
                            let newRow = tableBody.insertRow(-1);
                            let count = tableBody.rows.length;
                            newRow.innerHTML = '<th scope="row">' + count + '</th><input type="hidden" class="labour_id" name="labour_id" value="' + response['success'][0] + '"><td class="fw-bold">' + response['success'][1] + '</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold description" name="description" readonly value=' + response['success'][2] + '></td><td><input type="text" class="form-control form-control-sm text-center bg-light fw-bold service-charge" name="service-charge" placeholder="Ingresar cobro servicio">dolares</td><td><input type="text" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold" name="costo-total" readonly placeholder="$0.00"></td><td><button class="btn btn-success" onclick="cost_mano_obra(this)"><i class="fas fa-check text-white"></i></button></td><td><button class="btn btn-danger" onclick="delete_row_mano_obra(this)"><i class="fas fa-trash-alt"></i></button></td>';
                        },
                        500: function () {
                            console.log('error');
                        }
                    }
                });
            }
        }

        $("#servicios").val('Seleccionar...');

    }
    else {
        alert('Ingrese los datos requeridos');
        $("#servicios").val('Seleccionar...');
    }

}
*/

function cost_mano_obra(index) {

    let row = index.parentNode.parentNode;
    let id_labour = 0;
    id_labour = row.getElementsByTagName('input')[0].value;
    let total_laminas = document.getElementById('cantidadLaminas').value;
    let cobro_servicio = row.getElementsByTagName('input')[2].value;
    let costo_total;

    if (id_labour == 1 || id_labour == 2) {
        costo_total = Math.round((total_laminas * cobro_servicio) / 3.85);
    }
    if (id_labour == 3) {
        costo_total = Math.round(cobro_servicio / 3.85);
    }
    if (id_labour == 4 || id_labour == 5 || id_labour == 6 || id_labour == 7 || id_labour == 9 || id_labour == 10) {
        costo_total = cobro_servicio;
    }
    if (id_labour == 8) {
        costo_total = Math.round(cobro_servicio / 3.85);
    }
    validarInputsLabour(index);
    if (costo_total == "") {
        row.getElementsByTagName('input')[3].value = '$0.00';
    }
    else {
        row.getElementsByTagName('input')[3].value = '$' + costo_total;
    }

    // console.log('id_labour:' + id_labour + ', costo:' + row.getElementsByTagName('input')[3].value);

}


/*function delete_row_mano_obra(e) {

    document.getElementById("formContent").addEventListener('submit', (e) => {
        e.preventDefault();
    });

    let tableBody = document.getElementById('list-mano-obra');
    let row = e.parentNode.parentNode;
    tableBody.removeChild(row);

    let rows = tableBody.getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        let row = rows[i];
        let items = row.getElementsByTagName('th')[0];
        items.innerHTML = i + 1;
    }
}*/

function removeData() {

    document.getElementById('name').value = "";
    document.getElementById('long').value = "";
    document.getElementById('width').value = "";
    document.getElementById('thickness').value = "";
    document.getElementById('rows').value = "";
    document.getElementById('quantity').value = "";
    document.getElementById('warranty').value = "";
    document.getElementById('name').classList.remove('is-invalid');
    document.getElementById('long').classList.remove('is-invalid');
    document.getElementById('width').classList.remove('is-invalid');
    document.getElementById('thickness').classList.remove('is-invalid');
    document.getElementById('rows').classList.remove('is-invalid');
    document.getElementById('quantity').classList.remove('is-invalid');
    document.getElementById('warranty').classList.remove('is-invalid');
    $("#tube").val('Seleccionar...');
    $('#list-materials tr').remove();
    $('#list-mano-obra tr').remove();    

}















