CKEDITOR.plugins.add('miplugin',
{
    init: function (editor) {
        var pluginName = 'miplugin';
        editor.ui.addButton('Miplugin',
            {
                label: 'Probar plugin',
                command: 'probar',
                icon: CKEDITOR.plugins.getPath('miplugin') + 'images/image.png'
            });
        editor.addCommand('probar', { exec: mi_funcion});
    }
});
function mi_funcion() {
   alert('Soy una función');
}