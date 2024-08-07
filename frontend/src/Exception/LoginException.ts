
export class LoginException extends Error {

    protected errors


    constructor(message: string, response: Array<Object>) {
        super(message)
        this.errors = response
    }


    getErrors() {
        return this.errors
    }

}

