import EditableDataMap from '../interfaces/EditableDataMap';

export default interface ApiResponse {
    status: number;
    success: boolean;
    data: EditableDataMap;
}
