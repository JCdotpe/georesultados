// Create a new tour
var tour = new Tour();

// Add your steps
tour.addSteps([
    {
        element: "#dv_searchColegio", // element selector to show the popover next to;
        title: "NOMBRE DE LA INSTITUCIÓN EDUCATIVA",
        content: "Ingrese nombre completo o parte del nombre de la Institución Educativa"
    },
    {
        element: "#dv_searchParent",
        title: "CÓDIGO DE LOCAL",
        content: "Boom, bang, bam!"
    },
    {
        element: "#dv_dep", // element selector to show the popover next to;
        title: "DEPARTAMENTO",
        content: "We're going to make this quick and useful."
    },
    {
        element: "#dv_prov", // element selector to show the popover next to;
        title: "PROVINCIA",
        content: "We're going to make this quick and useful."
    },
    {
        element: "#dv_dist", // element selector to show the popover next to;
        title: "DISTRITO",
        content: "We're going to make this quick and useful."
    },
]);

// Initialize method on the Tour class. Get's everything loaded up and ready to go.
tour.init();

// This starts the tour itself
tour.start();