const API_BASE_URL = "http://localhost:8000/api";

const token = localStorage.getItem('authToken')

const api = {
    sales: {

        getAll: async () => {
            const response = await fetch(`${API_BASE_URL}/sales/list`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                }
            });
            return response;
        },

        getById: async (saleId) => {
            const response = await fetch(`${API_BASE_URL}/sales/list/${saleId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                }
            });
            return response;
        },

        store: async (saleData) => {
            const response = await fetch(`${API_BASE_URL}/sales/store`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
                body: JSON.stringify(saleData)
            });
            return response;
        },

        update: async (saleId, saleData) => {
            const response = await fetch(`${API_BASE_URL}/sales/update/${saleId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
                body: JSON.stringify(saleData)
            });
            return response;
        },

        delete: async (saleId) => {
            const response = await fetch(`${API_BASE_URL}/sales/destroy/${saleId}`, {
                method: "DELETE",
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                }
            });
            return response;
        },
        

    },

    sellers: {
        getAll: async () => {
            const response = await fetch(`${API_BASE_URL}/sellers/list`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                }
            });
            return response;
        },

        getById: async (sellerId) => {
            const response = await fetch(`${API_BASE_URL}/sellers/list/${sellerId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                }
            });
            return response;
        },

        store: async (sellerData) => {
            const response = await fetch(`${API_BASE_URL}/sellers/store`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
                body: JSON.stringify(sellerData)
            });
            return response;
        },

        update: async (sellerId, sellerData) => {
            const response = await fetch(`${API_BASE_URL}/sellers/update/${sellerId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
                body: JSON.stringify(sellerData)
            });
            return response;
        },

        delete: async (sellerId) => {
            const response = await fetch(`${API_BASE_URL}/sellers/destroy/${sellerId}`, {
                method: "DELETE",
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                }
            });
            return response;
        },

        sendCommissionReport: async (sellerId) => {

            const commissionData = {
                seller_id: sellerId,
                date: null
            };

            const response = await fetch(`${API_BASE_URL}/sales/send-commission-report`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                },
                body: JSON.stringify(commissionData)
            });
            return response;
        },

        getSalesBySellerIdGroupedDays: async (sellerId) => {
            const response = await fetch(`${API_BASE_URL}/sales/listBySellerGroupedDays/${sellerId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                }
            });
            return response;
        },
    },

    auth: {

        login: async (userData) => {
            const response = await fetch(`${API_BASE_URL}/auth/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            })
            return response;
        },

        register: async (userData) => {
            const response = await fetch(`${API_BASE_URL}/auth/register`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            })
            return response;
        },


    }

};

export default api;
