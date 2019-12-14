import { Notyf } from 'notyf';

const toast = new Notyf({
    duration: 1500,
    types: [
        {
            type: 'info',
            backgroundColor: 'gray'
        }
    ]
});

export default toast;
