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
    created_at: string;
    rooms?: Array<{
        id: number;
        room_number: string;
        type: string;
        price: number;
        status: string;
        active_assignment?: {
            tenant: {
                first_name: string;
                last_name: string;
                email: string;
            };
        };
    }>;
}

interface Props {
    boardingHouse: BoardingHouse;
    [key: string]: unknown;
}

export default function ShowBoardingHouse({ boardingHouse }: Props) {
    const handleDelete = () => {
        if (confirm('Are you sure you want to delete this boarding house?')) {
            router.delete(route('boarding-houses.destroy', boardingHouse.id));
        }
    };

    const occupiedRooms = boardingHouse.rooms?.filter(room => room.status === 'occupied') || [];
    const vacantRooms = boardingHouse.rooms?.filter(room => room.status === 'vacant') || [];

    return (
        <AppLayout>
            <Head title={`${boardingHouse.name} - Boarding House`} />
            
            <div className="p-6">
                <div className="flex justify-between items-start mb-6">
                    <div>
                        <h1 className="text-3xl font-bold mb-2">🏢 {boardingHouse.name}</h1>
                        <p className="text-muted-foreground">Boarding House Details</p>
                    </div>
                    <div className="flex space-x-3">
                        <Link href={route('boarding-houses.edit', boardingHouse.id)}>
                            <Button variant="outline">✏️ Edit</Button>
                        </Link>
                        <Button 
                            variant="outline" 
                            onClick={handleDelete}
                            className="text-red-600 hover:text-red-700"
                        >
                            🗑️ Delete
                        </Button>
                        <Link href={route('boarding-houses.index')}>
                            <Button variant="outline">← Back</Button>
                        </Link>
                    </div>
                </div>

                <div className="grid gap-6 md:grid-cols-2">
                    {/* Basic Information */}
                    <div className="border rounded-lg p-6 bg-card">
                        <h2 className="text-xl font-semibold mb-4">📋 Basic Information</h2>
                        <div className="space-y-3">
                            <div>
                                <label className="text-sm font-medium text-muted-foreground">Name</label>
                                <p className="text-lg">{boardingHouse.name}</p>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-muted-foreground">Owner</label>
                                <p>{boardingHouse.owner}</p>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-muted-foreground">Contact</label>
                                <p>{boardingHouse.contact}</p>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-muted-foreground">Address</label>
                                <p>{boardingHouse.address}</p>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-muted-foreground">Total Rooms</label>
                                <p className="text-2xl font-bold text-blue-600">{boardingHouse.number_of_rooms}</p>
                            </div>
                        </div>
                    </div>

                    {/* Statistics */}
                    <div className="border rounded-lg p-6 bg-card">
                        <h2 className="text-xl font-semibold mb-4">📊 Room Statistics</h2>
                        <div className="grid grid-cols-2 gap-4">
                            <div className="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                                <div className="text-2xl font-bold text-green-600">{occupiedRooms.length}</div>
                                <div className="text-sm text-green-700">Occupied</div>
                            </div>
                            <div className="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <div className="text-2xl font-bold text-blue-600">{vacantRooms.length}</div>
                                <div className="text-sm text-blue-700">Vacant</div>
                            </div>
                            <div className="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div className="text-2xl font-bold text-gray-600">{boardingHouse.rooms?.length || 0}</div>
                                <div className="text-sm text-gray-700">Total Rooms</div>
                            </div>
                            <div className="text-center p-4 bg-purple-50 rounded-lg border border-purple-200">
                                <div className="text-2xl font-bold text-purple-600">
                                    {boardingHouse.rooms?.length ? Math.round((occupiedRooms.length / boardingHouse.rooms.length) * 100) : 0}%
                                </div>
                                <div className="text-sm text-purple-700">Occupancy</div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Rooms List */}
                <div className="mt-8">
                    <div className="flex justify-between items-center mb-4">
                        <h2 className="text-xl font-semibold">🏠 Rooms</h2>
                        <Button>+ Add Room</Button>
                    </div>

                    {boardingHouse.rooms && boardingHouse.rooms.length > 0 ? (
                        <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                            {boardingHouse.rooms.map((room) => (
                                <div key={room.id} className="border rounded-lg p-4 bg-card">
                                    <div className="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 className="font-semibold">Room {room.room_number}</h3>
                                            <p className="text-sm text-muted-foreground capitalize">{room.type}</p>
                                        </div>
                                        <div className={`px-2 py-1 rounded-full text-xs font-medium ${
                                            room.status === 'occupied' ? 'bg-green-100 text-green-800' :
                                            room.status === 'vacant' ? 'bg-blue-100 text-blue-800' :
                                            'bg-yellow-100 text-yellow-800'
                                        }`}>
                                            {room.status}
                                        </div>
                                    </div>

                                    <div className="space-y-2">
                                        <p className="text-lg font-semibold">₱{room.price?.toLocaleString()}/month</p>
                                        
                                        {room.active_assignment && (
                                            <div className="bg-accent p-3 rounded">
                                                <p className="text-sm font-medium">Current Tenant:</p>
                                                <p className="text-sm">{room.active_assignment.tenant.first_name} {room.active_assignment.tenant.last_name}</p>
                                                <p className="text-xs text-muted-foreground">{room.active_assignment.tenant.email}</p>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="text-center py-8 border rounded-lg bg-card">
                            <div className="text-4xl mb-2">🏠</div>
                            <h3 className="text-lg font-semibold mb-2">No rooms added yet</h3>
                            <p className="text-muted-foreground mb-4">Start by adding rooms to this boarding house</p>
                            <Button>Add First Room</Button>
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}