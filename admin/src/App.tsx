import { Tabs, TabsContent, TabsList, TabsTrigger } from "~/components/ui/tabs";

const App = () => {
    return (
        <Tabs defaultValue="account" class="w-[400px]">
            <TabsList class="grid w-full grid-cols-2">
                <TabsTrigger value="account">Account</TabsTrigger>
                <TabsTrigger value="password">Password</TabsTrigger>
            </TabsList>
            <TabsContent value="account">Account Tab</TabsContent>
            <TabsContent value="password">Password Tab</TabsContent>
        </Tabs>
    );
};

export default App;
