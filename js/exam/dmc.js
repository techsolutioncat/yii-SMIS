$(document).ready(function() {
    $('#subject-inner').on('click', 'a.btn-print-pdf', function() {
        createPDF();
    });
});

function createPDF() {
    var element = document.getElementById('exam_content');
    html2pdf(element, {
        margin:1,
        padding:0,
        filename: 'myfile.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { scale: 2,  logging: true },
        jsPDF: { unit: 'in', format: 'A2', orientation: 'P' },
        class: createPDF
    });
};