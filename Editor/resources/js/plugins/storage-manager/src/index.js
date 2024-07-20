export default (editor, opts = {}) => {

    editor.StorageManager.config.onStore = (data, editor) => {
        const page = editor.Pages.getSelected();
        const component = page.getMainComponent();

        const html = editor.getHtml({ component });
        const css = editor.getCss({ component });
        const styles = data.styles;

        return {
            page,
            html,
            css,
            styles
        };
    }
};