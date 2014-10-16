// Create a new tour
var tour = new Tour({
    keyboard: true,
    template: "<div class='popover tour'>" +
                "<div class='arrow'></div>" +
                    "<h3 class='popover-title text-center'></h3>" +
                "<div class='popover-content'></div>" +
                    "<div class='popover-navigation'>" +
                        "<button class='btn btn-default btn-sm' data-role='prev'><i class='glyphicon glyphicon-chevron-left'></i> Atras</button>" +
                        "<button class='btn btn-default btn-sm' data-role='next'>Siguiente <i class='glyphicon glyphicon-chevron-right'></i></button>" +
                        "<button class='btn btn-default btn-sm' data-role='end'>Fin</button>" +
                    "</div>" +
                "</nav>" +
            "</div>"

});

// Add your steps
tour.addSteps([
    {
        element: "#searchCodigo",
        title: "<strong>CÓDIGO DE LOCAL</strong>",
        content: "Puede buscar también por el <strong>Código de Local Escolar</strong>.",
        animation: false,
        backdrop: false
    },
    {
        element: "#searchColegio", 
        title: "<strong>NOMBRE DE LA INSTITUCIÓN EDUCATIVA</strong>",
        content: "Puede realizar la búsqueda ingresando el nombre completo o parte del nombre de la <strong>Institución Educativa</strong>.",
        animation: false,
        backdrop: false
    },
    {
        element: "#dv_dep", 
        title: "<strong>DEPARTAMENTO</strong>",
        content: "Lista desplegable que contienen los <strong>departamentos</strong> del Perú. <br>Seleccione un departamento.",
        animation: false,
        backdrop: false
    },
    {
        element: "#dv_prov", 
        title: "<strong>PROVINCIA</strong>",
        content: "Lista desplegable que contienen las <strong>provincias</strong> de acuerdo al departamento seleccionado. <br>Seleccione una provincia.",
        animation: false,
        backdrop: false
    },
    {
        element: "#dv_dist", 
        title: "<strong>DISTRITO</strong>",
        content: "Lista desplegable que contienen los <strong>distritos</strong> de acuerdo a la provincia seleccionada. <br>Seleccione un distrito.",
        animation: false,
        backdrop: false
    },
    {
        element: "#filtrar", 
        title: "<strong>BUSCAR</strong>",
        content: "Este boton filtrar los datos ingresados deacuerdo a su criterio de búsqueda.",
        animation: false,
        backdrop: false,
        placement: "bottom"
    },
    {
        element: "#limpiar_inputs", 
        title: "<strong>LIMPIAR</strong>",
        content: "Este boton restablece los campos de búsqueda y los combo para que vuelva a realizar su búsqueda.",
        animation: false,
        backdrop: false,
        placement: "bottom"
    },
    {
        element: "#map-canvas", 
        title: "<strong>MAPA</strong>",
        content: "Contiene el colegio deacuerdo al Código de Local.",
        animation: false,
        backdrop: true,
        placement: "left"
    }
]);

tour.init();

tour.start();