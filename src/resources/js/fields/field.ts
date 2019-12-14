import EditableDataMap from '../interfaces/EditableDataMap';
import ApiResponse from '../interfaces/ApiResponse';

export default abstract class Field {
    public abstract render(): string;
    public abstract prepare(): EditableDataMap;
    public abstract send(): ApiResponse;
}

