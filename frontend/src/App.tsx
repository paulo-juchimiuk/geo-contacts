import { useState, useEffect } from 'react';
import { GoogleMap, Marker, useJsApiLoader } from '@react-google-maps/api';
import axios from 'axios';

type Contact = {
    id: number;
    name: string;
    latitude: number;
    longitude: number;
};

const containerStyle = {
    width: '100%',
    height: '100vh',
};

const center = {
    lat: -14.2350,
    lng: -51.9253,
};

function App() {
    const { isLoaded } = useJsApiLoader({
        googleMapsApiKey: import.meta.env.VITE_GOOGLE_MAPS_API_KEY as string,
    });

    const [contacts, setContacts] = useState<Contact[]>([]);

    useEffect(() => {
        const token = localStorage.getItem('token');

        axios
            .get('http://localhost/api/contacts', {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            })
            .then((res) => {
                setContacts(res.data.details.data);
            })
            .catch((err) => {
                console.error("Erro ao buscar contatos:", err);
            });
    }, []);

    if (!isLoaded) return <div>Carregando mapa...</div>;

    return (
        <GoogleMap
            mapContainerStyle={containerStyle}
            center={center}
            zoom={4}
        >
            {contacts.map((contact) => (
                <Marker
                    key={contact.id}
                    position={{ lat: contact.latitude, lng: contact.longitude }}
                    onClick={() => alert(`Contato: ${contact.name}`)}
                />
            ))}
        </GoogleMap>
    );
}

export default App;
