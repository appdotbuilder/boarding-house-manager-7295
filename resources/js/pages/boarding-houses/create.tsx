import React from 'react';
import { AppLayout } from '@/components/app-layout';
import { Head, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface BoardingHouseFormData {
    name: string;
    address: string;
    number_of_rooms: number;
    owner: string;
    contact: string;
    [key: string]: string | number;
}

export default function CreateBoardingHouse() {
    const { data, setData, post, processing, errors } = useForm<BoardingHouseFormData>({
        name: '',
        address: '',
        number_of_rooms: 0,
        owner: '',
        contact: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('boarding-houses.store'));
    };

    return (
        <AppLayout>
            <Head title="Add Boarding House" />
            
            <div className="p-6 max-w-2xl mx-auto">
                <div className="mb-6">
                    <h1 className="text-2xl font-bold">🏢 Add Boarding House</h1>
                    <p className="text-muted-foreground">Create a new boarding house property</p>
                </div>

                <form onSubmit={handleSubmit} className="space-y-6">
                    <div className="grid gap-6 md:grid-cols-2">
                        <div>
                            <label className="block text-sm font-medium mb-2">
                                Boarding House Name *
                            </label>
                            <input
                                type="text"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                className="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., Sunshine Boarding House"
                                required
                            />
                            {errors.name && (
                                <p className="text-red-600 text-sm mt-1">{errors.name}</p>
                            )}
                        </div>

                        <div>
                            <label className="block text-sm font-medium mb-2">
                                Number of Rooms *
                            </label>
                            <input
                                type="number"
                                value={data.number_of_rooms}
                                onChange={(e) => setData('number_of_rooms', parseInt(e.target.value))}
                                className="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                min="1"
                                required
                            />
                            {errors.number_of_rooms && (
                                <p className="text-red-600 text-sm mt-1">{errors.number_of_rooms}</p>
                            )}
                        </div>
                    </div>

                    <div>
                        <label className="block text-sm font-medium mb-2">
                            Address *
                        </label>
                        <textarea
                            value={data.address}
                            onChange={(e) => setData('address', e.target.value)}
                            className="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            rows={3}
                            placeholder="Complete address including street, city, and postal code"
                            required
                        />
                        {errors.address && (
                            <p className="text-red-600 text-sm mt-1">{errors.address}</p>
                        )}
                    </div>

                    <div className="grid gap-6 md:grid-cols-2">
                        <div>
                            <label className="block text-sm font-medium mb-2">
                                Owner Name *
                            </label>
                            <input
                                type="text"
                                value={data.owner}
                                onChange={(e) => setData('owner', e.target.value)}
                                className="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Property owner's full name"
                                required
                            />
                            {errors.owner && (
                                <p className="text-red-600 text-sm mt-1">{errors.owner}</p>
                            )}
                        </div>

                        <div>
                            <label className="block text-sm font-medium mb-2">
                                Contact Information *
                            </label>
                            <input
                                type="text"
                                value={data.contact}
                                onChange={(e) => setData('contact', e.target.value)}
                                className="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Phone number or email"
                                required
                            />
                            {errors.contact && (
                                <p className="text-red-600 text-sm mt-1">{errors.contact}</p>
                            )}
                        </div>
                    </div>

                    <div className="flex justify-end space-x-4">
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => window.history.back()}
                        >
                            Cancel
                        </Button>
                        <Button type="submit" disabled={processing}>
                            {processing ? 'Creating...' : 'Create Boarding House'}
                        </Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}