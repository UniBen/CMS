import axios from 'axios'
import toast from './toast'
import EditableDataMap from './interfaces/EditableDataMap'

export default class CMS {
    editables: any;

    constructor() {
        this.editables = document.querySelectorAll('[data-editable]');

        this.editables.forEach((content: HTMLElement) => {
            content.onclick = (e: Event) => {
                e.stopPropagation();
                return false;
            };

            content.onkeydown = (e: KeyboardEvent|any) => {
                if (e.keyCode === 13) {
                    let data: EditableDataMap = {};
                    const intent: string = e.target.dataset.editable;
                    const type: string = e.target.dataset.editableType;
                    const field: string = e.target.dataset.editableField;

                    document.querySelectorAll('[data-editable="' + intent + '"]').forEach((e: any) => {
                        data[e.dataset.editableField] = e.textContent;
                    });

                    toast.open({type: 'info', message: 'Updating.'});

                    axios.post('/uniben/cms/update', { intent, type, field, data })
                        .then(res => {
                            toast.success('Updated!');
                            setTimeout(() => location.reload(), 200)
                        })
                        .catch(err => {
                            toast.error('There was an error updating the page!');
                            console.error(err.message)
                        });

                    return false;
                }
            };
        })
    }
};
