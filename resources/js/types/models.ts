export interface PurchaseType{
    id:number;
    title:string;
    validity_period:null|number
}export interface ProductPurchase{
    product_id:number
    price:number
    purchase_type_id:number
    type:PurchaseType
}
export interface Product{
    id:number
    price:number
    title:string
    purchases:ProductPurchase[]
}
export interface Order{
    id:number
    user:number
    payment_time:string
    products:OrderProduct[]
}
export interface OrderProduct{
    id:number
    user:number
    price:number,
    product:Product
    purchase_type:PurchaseType
}
