export const validaCEP = (cep) => {
    if(cep.length === 9 || cep.length == 0 ){
        return true;
    }else {
        return false;
    }
}