import { ResponseError } from "../interfaces/responseError";


export class LoginException extends Error {

    protected errors


    constructor(message: string, response: ResponseError) {
        super(message)
        this.errors = response
    }


    getErrors() {
        return this.errors
    }

}

