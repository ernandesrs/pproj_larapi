<?php

namespace App\Models;

use App\Enums\ApplicationLayers;

class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * Map permissions enums classes
     * @param ?ApplicationLayers $layer
     * @return string[]
     */
    private static function mapPermissionsClasses(?ApplicationLayers $layer = null)
    {
        $layerAsNamespacePartial = $layer ? \Str::ucfirst($layer->value) : null;
        $directory = app_path('Enums\Permissions' . ($layerAsNamespacePartial ? '\\' . $layerAsNamespacePartial : ''));
        $namespace = 'App\Enums\Permissions';
        $enums = [];

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile() && $fileInfo->getExtension() === 'php') {
                $filePath = $fileInfo->getPathname();
                $contents = file_get_contents($filePath);

                if (preg_match('/namespace\s+([^;]+);/', $contents, $namespaceMatch)) {
                    $namespaceName = trim($namespaceMatch[1]);

                    if (stripos($namespaceName, $namespace) === 0) {
                        if (preg_match_all('/\benum\s+([a-zA-Z_][a-zA-Z0-9_]*)/', $contents, $enumMatches)) {
                            foreach ($enumMatches[1] as $enumName) {
                                $enums[] = $namespaceName . '\\' . $enumName;
                            }
                        } else {
                            //
                        }
                    }
                }
            }
        }

        return $enums;
    }

    /**
     * Get all defined permissions
     * @param ?ApplicationLayers $layer
     * @return array['resource_name'=>[//resource permissions]]
     */
    public static function getDefinedPermissions(?ApplicationLayers $layer = null): array
    {
        $permissions = [];
        $mappedPermissions = self::mapPermissionsClasses($layer);
        foreach ($mappedPermissions as $permission) {
            $resourceName = \Str::slug($permission::resourceName());
            $permissions[$resourceName] = $permission::cases();
        }
        return $permissions;
    }
}
