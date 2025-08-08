import React from 'react';
import { AppLayout } from '@/components/app-layout';
import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface BoardingHouse {
    id: number;
    name: string;
    address: string;
    number_of_rooms: number;
    owner: string;
    contact: string;
    rooms_count?: number;
    occupied_rooms_count?: number;
    vacant_rooms_count?: number;
    created_at: string;
}

interface Props {
    boardingHouses: {
        data: BoardingHouse[];
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
        meta: {
            current_page: number;
            last_page: number;
            per_page: number;
            total: number;
        };
    };
    [key: string]: unknown;
}

export default function BoardingHousesIndex({ boardingHouses }: Props) {
    const handleDelete = (id: number) => {
        if (confirm('Are you sure you want to delete this boarding house?')) {
            router.delete(route('boarding-houses.destroy', id));
        }
    };

    return (
        <AppLayout>
            <Head title="Boarding Houses" />
            
            <div className="p-6">
                <div className="flex justify-between items-center mb-6">
                    <div>
                        <h1 className="text-2xl font-bold">🏢 Boarding Houses</h1>
                        <p className="text-muted-foreground">Manage your boarding house properties</p>
                    </div>
                    <Link href={route('boarding-houses.create')}>
                        <Button>Add Boarding House</Button>
                    </Link>
                </div>

                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    {boardingHouses.data.map((house) => (
                        <div key={house.id} className="border rounded-lg p-6 bg-card">
                            <div className="flex justify-between items-start mb-4">
                                <div>
                                    <h3 className="text-lg font-semibold">{house.name}</h3>
                                    <p className="text-sm text-muted-foreground">Owner: {house.owner}</p>
                                </div>
                                <div className="flex space-x-2">
                                    <Link href={route('boarding-houses.edit', house.id)}>
                                        <Button variant="outline" size="sm">Edit</Button>
                                    </Link>
                                    <Button 
                                        variant="outline" 
                                        size="sm" 
                                        onClick={() => handleDelete(house.id)}
                                        className="text-red-600 hover:text-red-700"
                                    >
                                        Delete
                                    </Button>
                                </div>
                            </div>

                            <div className="space-y-2 mb-4">
                                <p className="text-sm">📍 {house.address}</p>
                                <p className="text-sm">📞 {house.contact}</p>
                                <p className="text-sm">🏠 {house.number_of_rooms} rooms</p>
                            </div>

                            {house.rooms_count !== undefined && (
                                <div className="bg-accent rounded p-3">
                                    <div className="flex justify-between text-sm">
                                        <span>Occupied:</span>
                                        <span className="text-green-600">{house.occupied_rooms_count || 0}</span>
                                    </div>
                                    <div className="flex justify-between text-sm">
                                        <span>Vacant:</span>
                                        <span className="text-blue-600">{house.vacant_rooms_count || 0}</span>
                                    </div>
                                </div>
                            )}

                            <div className="mt-4">
                                <Link href={route('boarding-houses.show', house.id)}>
                                    <Button variant="outline" className="w-full">View Details</Button>
                                </Link>
                            </div>
                        </div>
                    ))}
                </div>

                {boardingHouses.data.length === 0 && (
                    <div className="text-center py-12">
                        <div className="text-6xl mb-4">🏢</div>
                        <h3 className="text-lg font-semibold mb-2">No boarding houses yet</h3>
                        <p className="text-muted-foreground mb-4">Start by adding your first boarding house</p>
                        <Link href={route('boarding-houses.create')}>
                            <Button>Add First Boarding House</Button>
                        </Link>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}